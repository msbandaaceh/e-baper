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

    public function ambil_barang() {
        $data['peran'] = $this->session->userdata('peran');
        $this->load->view('ambil_barang', $data);
    }

    public function page($halaman)
    {
        // Amanin nama file view agar tidak sembarang file bisa diload
        $allowed = [
            'dashboard',
            'data_barang',
            'keranjang',
            'validasi',
            'riwayat_permintaan',
            'permohonan_valid',
            'register_permohonan',
            'panduan_penggunaan',
            'dokumentasi_teknis'
        ];

        if (in_array($halaman, $allowed)) {
            $data['peran'] = $this->session->userdata('peran');
            $data['page'] = $halaman;

            // Cek akses untuk dokumentasi teknis (hanya admin)
            if ($halaman == 'dokumentasi_teknis') {
                if (!in_array($data['peran'], ['admin'])) {
                    show_404();
                    return;
                }
            }

            // Cek akses untuk register permohonan (hanya admin dan operator)
            if ($halaman == 'register_permohonan') {
                if (!in_array($data['peran'], ['admin', 'operator'])) {
                    show_404();
                    return;
                }
            }

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
        $cookie_domain = $this->config->item('sso_server');
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
        $sso_server = $this->config->item('sso_server');
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

    public function show_tabel_riwayat_permohonan()
    {
        $query = $this->model->get_seleksi_array('register_permohonan', ['pegawai_id' => $this->session->userdata('pegawai_id')], ['status' => 'ASC', 'created_on' => 'DESC'])->result();

        $data = [];
        foreach ($query as $row) {
            $date = new DateTime($row->created_on);
            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'tgl' => $this->tanggalhelper->convertDayDate($date->format('Y-m-d')),
                'status' => $row->status
            ];
        }

        echo json_encode(['data_riwayat' => $data]);
    }

    public function show_detail_riwayat_permohonan()
    {
        $permohonan_id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        # Ambil Data Barang sesuai Permohonan Id
        $queryBarang = $this->model->get_seleksi_array('v_detail_permohonan', ['permohonan_id' => $permohonan_id])->result();
        $dataBarang = [];
        foreach ($queryBarang as $row) {
            $dataBarang[] = [
                'nama_barang' => $row->nama_barang,
                'jumlah' => $row->jumlah_permohonan,
                'status' => $row->status_permohonan
            ];
        }

        $tgl_permohonan = $this->model->get_seleksi_array('register_permohonan', ['id' => $permohonan_id])->row()->created_on;
        $date = new DateTime($tgl_permohonan);
        $tgl = $this->tanggalhelper->convertDayDate($date->format('Y-m-d'));

        # Ambil Riwayat Approval sesuai Permohonan Id
        $queryRiwayat = $this->model->get_seleksi_array('register_approval', ['permohonan_id' => $permohonan_id], ['created_on' => 'ASC'])->result();
        $dataRiwayat = [];
        $posisi = 'kanan';
        foreach ($queryRiwayat as $row) {
            $date = new DateTime($row->created_on);
            switch ($row->level) {
                case 'Kasub' : $level = 'Kepala Sub Umum Keuangan'; break;
                case 'Sekretaris' : $level = 'Seketaris'; break;
                case 'operator' : $level = 'Operator Persediaan'; break; 
            }

            $dataRiwayat[] = [
                'created_by' => $row->created_by,
                'tanggal' => $this->tanggalhelper->convertDayDate($date->format('Y-m-d')),
                'level' => $level,
                'posisi' => $posisi
            ];

            $posisi = ($posisi === 'kanan') ? 'kiri' : 'kanan';
        }

        echo json_encode(['data_barang' => $dataBarang, 'tanggal_permohonan' => $tgl, 'data_riwayat' => $dataRiwayat]);
    }

    /**
     * Menampilkan tabel semua permohonan (untuk admin dan operator)
     */
    public function show_tabel_register_permohonan()
    {
        $query = $this->model->get_all_permohonan();

        if ($query === 0 || $query->num_rows() === 0) {
            echo json_encode(['data_register' => []]);
            return;
        }

        $data = [];
        foreach ($query->result() as $row) {
            // Ambil data pegawai dari SSO
            $params = [
                'tabel' => 'v_pegawai',
                'kolom_seleksi' => 'id',
                'seleksi' => $row->pegawai_id
            ];

            $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);
            $nama_pegawai = 'Tidak Diketahui';
            if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                $nama_pegawai = $result['response']['data'][0]['nama_gelar'] ?? 'Tidak Diketahui';
            }

            // Format tanggal
            $date = new DateTime($row->created_on);
            $tgl = $this->tanggalhelper->convertDayDate($date->format('Y-m-d'));

            // Status label
            $status_label = '';
            $status_badge = '';
            switch ($row->status) {
                case '0':
                    $status_label = 'Menunggu Validasi';
                    $status_badge = 'warning';
                    break;
                case '1':
                    $status_label = 'Disetujui Kasub';
                    $status_badge = 'info';
                    break;
                case '2':
                    $status_label = 'Disetujui Sekretaris';
                    $status_badge = 'primary';
                    break;
                case '3':
                    $status_label = 'Selesai';
                    $status_badge = 'success';
                    break;
                default:
                    $status_label = 'Tidak Diketahui';
                    $status_badge = 'secondary';
            }

            $data[] = [
                'id' => base64_encode($this->encryption->encrypt($row->id)),
                'nama_pegawai' => $nama_pegawai,
                'tanggal' => $tgl,
                'status' => $row->status,
                'status_label' => $status_label,
                'status_badge' => $status_badge
            ];
        }

        echo json_encode(['data_register' => $data]);
    }

    /**
     * Menampilkan detail permohonan untuk register (untuk admin dan operator)
     */
    public function show_detail_register_permohonan()
    {
        $permohonan_id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        // Ambil data permohonan
        $permohonan = $this->model->get_seleksi_array('register_permohonan', ['id' => $permohonan_id])->row();
        
        if (!$permohonan) {
            echo json_encode(['success' => false, 'message' => 'Data permohonan tidak ditemukan']);
            return;
        }

        // Ambil data pegawai
        $params = [
            'tabel' => 'v_pegawai',
            'kolom_seleksi' => 'id',
            'seleksi' => $permohonan->pegawai_id
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);
        $nama_pegawai = 'Tidak Diketahui';
        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $nama_pegawai = $result['response']['data'][0]['nama_gelar'] ?? 'Tidak Diketahui';
        }

        // Format tanggal
        $date = new DateTime($permohonan->created_on);
        $tgl = $this->tanggalhelper->convertDayDate($date->format('Y-m-d'));

        // Ambil detail barang
        $queryBarang = $this->model->get_seleksi_array('v_detail_permohonan', ['permohonan_id' => $permohonan_id])->result();
        $dataBarang = [];
        foreach ($queryBarang as $row) {
            $status_label = '';
            switch ($row->status_permohonan) {
                case '0':
                    $status_label = 'Menunggu';
                    break;
                case '1':
                    $status_label = 'Disetujui';
                    break;
                case '2':
                    $status_label = 'Ditolak';
                    break;
                default:
                    $status_label = 'Tidak Diketahui';
            }

            $dataBarang[] = [
                'nama_barang' => $row->nama_barang,
                'jumlah_permohonan' => $row->jumlah_permohonan,
                'jumlah_diberikan' => $row->jumlah_diberikan ?? '-',
                'status' => $row->status_permohonan,
                'status_label' => $status_label,
                'keterangan' => $row->keterangan ?? '-'
            ];
        }

        // Ambil riwayat approval
        $queryRiwayat = $this->model->get_seleksi_array('register_approval', ['permohonan_id' => $permohonan_id], ['created_on' => 'ASC'])->result();
        $dataRiwayat = [];
        foreach ($queryRiwayat as $row) {
            $date = new DateTime($row->created_on);
            switch ($row->level) {
                case 'Kasub':
                    $level = 'Kepala Sub Umum Keuangan';
                    break;
                case 'Sekretaris':
                    $level = 'Sekretaris';
                    break;
                case 'operator':
                    $level = 'Operator Persediaan';
                    break;
                default:
                    $level = $row->level;
            }

            $dataRiwayat[] = [
                'created_by' => $row->created_by,
                'tanggal' => $this->tanggalhelper->convertDayDate($date->format('Y-m-d')),
                'level' => $level
            ];
        }

        echo json_encode([
            'success' => true,
            'nama_pegawai' => $nama_pegawai,
            'tanggal_permohonan' => $tgl,
            'status' => $permohonan->status,
            'data_barang' => $dataBarang,
            'data_riwayat' => $dataRiwayat
        ]);
    }
}