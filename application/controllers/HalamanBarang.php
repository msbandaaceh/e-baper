<?php

class HalamanBarang extends MY_Controller
{

    public function show_barang()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $daftar_kategori = array();
        $get_kategori = $this->model->get_seleksi_array('ref_kategori')->result_array();
        foreach ($get_kategori as $kategori) {
            $daftar_kategori[$kategori['id']] = $kategori['nama_kategori'];
        }

        $daftar_satuan = array();
        $get_satuan = $this->model->get_seleksi_array('ref_satuan')->result_array();
        foreach ($get_satuan as $satuan) {
            $daftar_satuan[$satuan['id']] = $satuan['nama_satuan'];
        }

        $nama = '';
        $kode = '';
        $deskripsi = '';
        $stok = '';
        $foto = '';
        $nama_satuan = '';

        if ($id == '-1') {
            $kategori = form_dropdown('kategori', $daftar_kategori, '', 'class = "form-control select" id="kategori"');
            $satuan = form_dropdown('satuan', $daftar_satuan, '', 'class = "form-control select" id="satuan"');
        } else {
            $get_barang = $this->model->get_seleksi_array('v_register_barang', ['id' => $id]);
            if ($get_barang->num_rows() > 0) {
                $kategori_barang = $get_barang->row()->kategori_id;
                $satuan_barang = $get_barang->row()->satuan_id;
                $nama = $get_barang->row()->nama_barang;
                $kode = $get_barang->row()->kode_barang;
                $deskripsi = $get_barang->row()->deskripsi;
                $stok = $get_barang->row()->stok - $get_barang->row()->stok_reserved;
                $foto = $get_barang->row()->foto;
                $nama_satuan = $get_barang->row()->nama_satuan;
            }

            $kategori = form_dropdown('kategori', $daftar_kategori, $kategori_barang, 'class = "form-control select" id="kategori"');
            $satuan = form_dropdown('satuan', $daftar_satuan, $satuan_barang, 'class = "form-control select" id="satuan"');
        }
        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'kategori' => $kategori,
                'satuan' => $satuan,
                'nama' => $nama,
                'kode' => $kode,
                'deskripsi' => $deskripsi,
                'stok' => $stok,
                'foto' => 'assets/images/barang/' . $foto,
                'nama_satuan' => $nama_satuan
            )
        );
        return;
    }

    public function show_daftar_barang()
    {
        $query = $this->model->get_seleksi_array('v_register_barang', '', ['nama_barang' => 'ASC', 'stok' => 'DESC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama_barang' => $row->nama_barang,
                'foto' => 'assets/images/barang/' . $row->foto,
                'nama_satuan' => $row->nama_satuan,
                'stok' => $row->stok - $row->stok_reserved,
            ];
        }

        echo json_encode(['data_barang' => $data]);
    }

    public function show_daftar_barang_kategori()
    {
        $id = $this->input->post('id');
        $query = $this->model->get_seleksi_array('register_barang', ['kategori_id' => $id], ['nama_barang' => 'ASC', 'stok' => 'DESC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama_barang' => $row->nama_barang,
                'foto' => 'assets/images/barang/' . $row->foto,
                'stok' => $row->stok - $row->stok_reserved,
            ];
        }

        echo json_encode(['data_barang' => $data]);
    }

    public function show_daftar_keranjang()
    {
        $query = $this->model->get_seleksi_array('v_keranjang', ['pegawai_id' => $this->session->userdata('pegawai_id'), 'status' => '0'], ['created_on' => 'ASC'])->result();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'id_jumlah' => $row->id,
                'nama_barang' => $row->nama_barang,
                'foto' => 'assets/images/barang/' . $row->foto,
                'stok' => $row->stok,
                'jumlah' => $row->jumlah,
            ];
        }

        echo json_encode(['data_keranjang' => $data]);
    }

    public function simpan_barang()
    {
        $this->form_validation->set_rules('nama', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('kode', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('stok', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('satuan', 'Tempat/Lokasi Agenda Rapat', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $data = [
            'id' => $this->input->post('id'),
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi'),
            'stok' => $this->input->post('stok'),
            'kategori' => $this->input->post('kategori'),
            'satuan' => $this->input->post('satuan')
        ];

        $data['foto'] = '';

        if ($this->input->post('id') == '-1') {
            if ($_FILES && isset($_FILES['gambar'])) {
                $config['upload_path'] = 'assets/images/barang/';
                $config['allowed_types'] = 'png';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                }

                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];

                // Kompresi gambar
                $this->_compress_image($file_path, $file_path, 60); // 60% quality

            } else {
                echo json_encode(['success' => 2, 'message' => 'Foto Barang Tidak Boleh Kosong']);
                return;
            }

            $data['foto'] = $upload_data['file_name'];
        } else {
            if ($_FILES && !empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = 'assets/images/barang/';
                $config['allowed_types'] = 'png';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, true);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                }

                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];

                // Kompresi gambar
                $this->_compress_image($file_path, $file_path, 60); // 60% quality
                $data['foto'] = $upload_data['file_name'];
            }
        }

        $result = $this->model->proses_simpan_data_barang($data);
        if ($result['status']) {
            echo json_encode(['success' => 1, 'message' => $result['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $result['message']]);
        }
    }

    public function hapus_barang()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $hapus = $this->model->pembaharuan_data('register_barang', ['hapus' => '1', 'modified_on' => date('Y-m-d H:i:s'), 'modified_by' => $this->session->userdata('fullname')], 'id', $id);

        if ($hapus == 1) {
            echo json_encode(
                array(
                    'st' => 1
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => 0
                )
            );
        }

        return;
    }

    private function _compress_image($source_path, $destination_path, $quality = 25)
    {
        $info = getimagesize($source_path);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source_path);
                imagejpeg($image, $destination_path, $quality);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source_path);
                imagejpeg($image, $destination_path, $quality); // convert to JPEG
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($source_path);
                imagejpeg($image, $destination_path, $quality);
                break;
            default:
                return false;
        }

        imagedestroy($image);
        return true;
    }

    public function show_kategori()
    {
        $id = $this->input->post('id');

        if ($id != '-1') {
            $query = $this->model->get_seleksi_array('ref_kategori', ['id' => $id]);

            echo json_encode(
                array(
                    'nama_kategori' => $query->row()->nama_kategori,
                    'id' => $id,
                )
            );
        } else {
            $dataKategori = $this->model->get_seleksi_array('ref_kategori')->result_array();
            #die(var_dump($dataKategori));

            echo json_encode(
                array(
                    'id' => $id,
                    'data_kategori' => $dataKategori
                )
            );
        }

        return;
    }

    public function simpan_kategori()
    {
        $this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');
        $nama = $this->input->post('nama');

        if ($id) {
            $data = array(
                'nama_kategori' => $nama,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->pembaharuan_data('ref_kategori', $data, 'id', $id);

        } else {
            $data = array(
                'nama_kategori' => $nama,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->simpan_data('ref_kategori', $data);
        }

        if ($query === 1) {
            echo json_encode(['success' => 1, 'message' => 'Simpan Kategori Berhasil']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Gagal Simpan Kategori']);
        }
    }

    public function show_satuan()
    {
        $id = $this->input->post('id');

        if ($id != '-1') {
            $query = $this->model->get_seleksi_array('ref_satuan', ['id' => $id]);

            echo json_encode(
                array(
                    'nama_satuan' => $query->row()->nama_satuan,
                    'id' => $id,
                )
            );
        } else {
            $data = $this->model->get_seleksi_array('ref_satuan')->result_array();
            #die(var_dump($dataKategori));

            echo json_encode(
                array(
                    'id' => $id,
                    'data_satuan' => $data
                )
            );
        }

        return;
    }

    public function simpan_satuan()
    {
        $this->form_validation->set_rules('nama', 'Nama Satuan', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');
        $nama = $this->input->post('nama');

        if ($id) {
            $data = array(
                'nama_satuan' => $nama,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->pembaharuan_data('ref_satuan', $data, 'id', $id);

        } else {
            $data = array(
                'nama_satuan' => $nama,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->simpan_data('ref_satuan', $data);
        }

        if ($query === 1) {
            echo json_encode(['success' => 1, 'message' => 'Simpan Satuan Berhasil']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Gagal Simpan Satuan']);
        }
    }

    public function tambah_keranjang()
    {
        $this->form_validation->set_rules('jumlah', 'Jumlah Barang', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong']);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => 2, 'message' => validation_errors()]);
            return;
        }

        $data = [
            'id' => $this->input->post('id'),
            'jumlah' => $this->input->post('jumlah')
        ];

        $query = $this->model->proses_tambah_keranjang($data);

        if ($query['status'] == true) {
            echo json_encode(['success' => 1, 'message' => $query['message']]);
        } else {
            echo json_encode(['success' => 3, 'message' => $query['message']]);
        }
    }

    public function update_jumlah_barang_keranjang()
    {
        $id = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');

        $this->model->pembaharuan_data('keranjang', ['jumlah' => $jumlah], 'id', $id);
    }

    public function hapus_keranjang()
    {
        $id = $this->input->post('id');
        $hapus = $this->model->pembaharuan_data('keranjang', ['hapus' => '1'], 'id', $id);

        if ($hapus == 1) {
            echo json_encode(
                array(
                    'st' => 1
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => 0
                )
            );
        }

        return;
    }

    public function checkout()
    {
        $keranjang = $this->input->post('keranjang');

        if (!$keranjang) {
            echo json_encode(['success' => '2', 'message' => 'Keranjang kosong']);
            return;
        }

        $cek_permohonan = $this->model->get_seleksi_array('register_permohonan', ['pegawai_id' => $this->session->userdata('pegawai_id'), 'status' => '0']);
        if ($cek_permohonan->num_rows() > 0) {
            echo json_encode(['success' => 3, 'message' => 'Tidak bisa Checkout, Ada Permohonan Anda Yang Belum Selesai']);
        } else {
            $result = $this->model->proses_checkout_barang($keranjang);
            if ($result['status']) {
                echo json_encode(['success' => 1, 'message' => $result['message']]);
            } else {
                echo json_encode(['success' => 3, 'message' => $result['message']]);
            }
        }
    }
}