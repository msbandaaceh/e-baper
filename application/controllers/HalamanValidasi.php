<?php

class HalamanValidasi extends MY_Controller
{
    public function show_tabel_validasi()
    {
        $jabatan_id = $this->session->userdata('jab_id');

        if ($jabatan_id == '10')
            $status = '0';
        elseif ($jabatan_id == '5')
            $status = '1';
        else
            if ($this->session->userdata('peran') == 'operator')
                $status = '2';

        $query = $this->model->get_seleksi_array('register_permohonan', ['status' => $status], ['status' => 'ASC'])->result();

        $data = [];
        foreach ($query as $row) {
            $params = [
                'tabel' => 'v_pegawai',
                'kolom_seleksi' => 'id',
                'seleksi' => $row->pegawai_id
            ];

            $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);
            if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                $nama_pegawai = $result['response']['data'][0]['nama_gelar'];
            }

            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama_pegawai' => $nama_pegawai,
                'status' => $row->status,
            ];
        }

        echo json_encode(['data_validasi' => $data]);
    }

    public function show_detail_permohonan()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $query = $this->model->get_seleksi_array('v_detail_permohonan', ['permohonan_id' => $id, 'status_permohonan' => '0'], ['detail_permohonan_id' => 'ASC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'detail_id' => $row->detail_permohonan_id,
                'nama_barang' => $row->nama_barang,
                'foto' => 'assets/images/barang/' . $row->foto,
                'stok' => $row->stok,
                'jumlah' => $row->jumlah_permohonan,
                'keterangan' => $row->keterangan
            ];
        }

        echo json_encode(['judul' => 'DETAIL PERMOHONAN PEGAWAI', 'permohonan_id' => base64_encode($this->encryption->encrypt($id)), 'data_keranjang' => $data]);
    }

    public function show_detail_permohonan_valid()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $query = $this->model->get_seleksi_array('v_detail_permohonan', ['permohonan_id' => $id, 'status_permohonan' => '1'], ['detail_permohonan_id' => 'ASC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'detail_id' => $row->detail_permohonan_id,
                'nama_barang' => $row->nama_barang,
                'jumlah' => $row->jumlah_permohonan
            ];
        }

        echo json_encode(['judul' => 'DETAIL PERMOHONAN PEGAWAI', 'permohonan_id' => base64_encode($this->encryption->encrypt($id)), 'data_valid' => $data]);
    }

    public function simpan_validasi()
    {
        $permohonan_id = $this->encryption->decrypt(base64_decode($this->input->post('permohonan_id')));
        $data_barang = $this->input->post('detail');

        $data = [
            'permohonan_id' => $permohonan_id,
            'data_barang' => $data_barang
        ];

        $result = $this->model->proses_validasi_barang($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function simpan_konfirmasi()
    {
        $permohonan_id = $this->encryption->decrypt(base64_decode($this->input->post('permohonan_id')));
        $data_barang = $this->input->post('detail');

        $data = [
            'permohonan_id' => $permohonan_id,
            'data_barang' => $data_barang
        ];

        $result = $this->model->proses_konfirmasi_permohonan($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }
}