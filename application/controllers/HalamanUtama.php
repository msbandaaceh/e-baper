<?php

class HalamanUtama extends MY_Controller
{
    public function index()
    {
        #die(var_dump($this->session->all_userdata()));
        $data['peran'] = $this->session->userdata('peran');
        $data['page'] = 'dashboard';

        $this->load->view('layout', $data);
    }

    public function page($halaman)
    {
        // Amanin nama file view agar tidak sembarang file bisa diload
        $allowed = [
            'dashboard',
            'data_barang',
            'keranjang'
        ];

        if (in_array($halaman, $allowed)) {
            $data['peran'] = $this->session->userdata('peran');
            $data['page'] = $halaman;

            if ($halaman == 'data_barang') {
                $data['kategori'] = $this->model->get_seleksi_array('ref_kategori')->result();
            } elseif ($halaman == 'dashboard') {
                $data['kategori'] = $this->model->get_seleksi_array('ref_kategori')->result();
            }

            $this->load->view($halaman, $data);
        } else {
            show_404();
        }
    }

    public function cek_token_sso()
    {
        $token = $this->input->cookie('sso_token');
        $cookie_domain = $this->session->userdata('sso_server');
        $sso_api = $cookie_domain . "api/cek_token?sso_token={$token}";
        $response = file_get_contents($sso_api);
        $data = json_decode($response, true);

        if ($data['status'] == 'success') {
            echo json_encode(['valid' => true]);
        } else {
            echo json_encode(['valid' => false, 'message' => 'Token Expired, Silakan login ulang', 'url' => $cookie_domain . 'login']);
        }
    }

    public function keluar()
    {
        $sso_server = $this->session->userdata('sso_server');
        $this->session->sess_destroy();
        redirect($sso_server . '/keluar');
    }

    public function show_role()
    {
        $id = $this->input->post('id');
        $data = [
            "tabel" => "v_users",
            "kolom_seleksi" => "status_pegawai",
            "seleksi" => "1"
        ];

        $users = $this->apihelper->get('apiclient/get_data_seleksi', $data);

        $pegawai = array();
        if ($users['status_code'] === '200') {
            foreach ($users['response']['data'] as $item) {
                $pegawai[$item['pegawai_id']] = $item['fullname'];
            }
        }

        if ($id != '-1') {
            $query = $this->model->get_seleksi_array('peran', ['id' => $id]);

            echo json_encode(
                array(
                    'pegawai' => $users['response']['data'],
                    'role' => $pegawai,
                    'id' => $id,
                    'editPegawai' => $query->row()->pegawai_id,
                    'editPeran' => $query->row()->role
                )
            );
        } else {
            $dataPeran = $this->model->get_data_peran();
            #die(var_dump($dataPeran));

            echo json_encode(
                array(
                    'pegawai' => $users['response']['data'],
                    'role' => $pegawai,
                    'data_peran' => $dataPeran
                )
            );
        }

        return;
    }

    public function simpan_peran()
    {
        $id = $this->input->post('id');
        $pegawai = $this->input->post('pegawai');
        $peran = $this->input->post('peran');

        if ($id) {
            $data = array(
                'pegawai_id' => $pegawai,
                'role' => $peran,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);


        } else {
            $query = $this->model->get_seleksi_array('peran', ['pegawai_id' => $pegawai]);
            if ($query->num_rows() > 0) {
                echo json_encode(['success' => 2, 'message' => 'Pegawai tersebut sudah memiliki peran']);
            }

            $data = array(
                'pegawai_id' => $pegawai,
                'role' => $peran,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->simpan_data('peran', $data);
            $pesan = "Anda telah ditunjuk menjadi Operator Persediaan, silakan akses E-BAPER melalui LITERASI atau akses e-baper.ms-bandaaceh.go.id. Terima Kasih.";

            $dataNotif = array(
                'jenis_pesan' => 'barang',
                'id_pemohon' => $this->session->userdata("userid"),
                'pesan' => $pesan,
                'id_tujuan' => $pegawai,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->model->kirim_notif($dataNotif);
        }

        if ($query === 1) {
            echo json_encode(['success' => 1, 'message' => 'Penunjukan Peran Pegawai Berhasil']);
        } else {
            echo json_encode(['success' => 3, 'message' => 'Gagal Menunjuk Peran Pegawai']);
        }
    }

    public function aktif_peran()
    {
        $id = $this->input->post('id');

        $data = array(
            'hapus' => '0',
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        $get_pegawai = $this->model->get_seleksi_array('peran', ['id' => $id])->row()->pegawai_id;
        $pesan = "Anda telah diaktifkan menjadi Operator Persediaan, silakan akses E-BAPER melalui LITERASI atau akses e-baper.ms-bandaaceh.go.id. Terima Kasih.";

        $dataNotif = array(
            'jenis_pesan' => 'barang',
            'id_pemohon' => $this->session->userdata("userid"),
            'pesan' => $pesan,
            'id_tujuan' => $get_pegawai,
            'created_by' => $this->session->userdata('fullname'),
            'created_on' => date('Y-m-d H:i:s')
        );

        $this->model->kirim_notif($dataNotif);

        if ($query == '1') {
            echo json_encode(
                array(
                    'st' => '1'
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => '0'
                )
            );
        }
    }

    public function blok_peran()
    {
        $id = $this->input->post('id');

        $data = array(
            'hapus' => '1',
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        );
        $get_pegawai = $this->model->get_seleksi_array('peran', ['id' => $id])->row()->pegawai_id;
        $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        $pesan = "Anda telah dinonaktifkan menjadi Operator Persediaan. Terima Kasih.";

        $dataNotif = array(
            'jenis_pesan' => 'barang',
            'id_pemohon' => $this->session->userdata("userid"),
            'pesan' => $pesan,
            'id_tujuan' => $get_pegawai,
            'created_by' => $this->session->userdata('fullname'),
            'created_on' => date('Y-m-d H:i:s')
        );

        $this->model->kirim_notif($dataNotif);

        if ($query == '1') {
            echo json_encode(
                array(
                    'st' => '1'
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => '0'
                )
            );
        }
    }
}