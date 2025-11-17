<?php

class Model extends CI_Model
{
    private $db_sso;

    public function __construct()
    {
        parent::__construct();

        // Inisialisasi variabel private dengan nilai dari session
        $this->db_sso = $this->session->userdata('sso_db');
    }

    private function add_audittrail($action, $title, $table, $descrip)
    {

        $params = [
            'tabel' => 'sys_audittrail',
            'data' => [
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'action' => $action,
                'title' => $title,
                'tablename' => $table,
                'description' => $descrip,
                'username' => $this->session->userdata('username')
            ]
        ];

        $this->apihelper->post('apiclient/simpan_data', $params);
    }

    public function cek_aplikasi($id)
    {
        $params = [
            'tabel' => 'ref_client_app',
            'kolom_seleksi' => 'id',
            'seleksi' => $id
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            $this->session->set_userdata(
                [
                    'nama_client_app' => $user_data['nama_app'],
                    'deskripsi_client_app' => $user_data['deskripsi']
                ]
            );
        }
    }

    public function kirim_notif($data)
    {
        $params = [
            'tabel' => 'sys_notif',
            'data' => $data
        ];

        $this->apihelper->post('apiclient/simpan_data', $params);
    }

    public function get_data_peran()
    {
        $this->db->select('l.id AS id, u.id AS pegawai_id, u.nama_gelar AS nama, l.role AS peran, l.hapus AS hapus');
        $this->db->from('peran l');
        $this->db->join($this->db_sso . '.v_pegawai u', 'l.pegawai_id = u.id', 'left');
        $this->db->order_by('l.id', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_seleksi_array($tabel, $where = [], $order_by = [])
    {
        try {
            $this->db->where('hapus', '0');

            // multiple where
            if (!empty($where)) {
                foreach ($where as $kolom => $nilai) {
                    $this->db->where($kolom, $nilai);
                }
            }

            // multiple order by
            if (!empty($order_by)) {
                foreach ($order_by as $kolom => $arah) {
                    $this->db->order_by($kolom, $arah); // ASC / DESC
                }
            }

            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function cek_status_permohonan()
    {
        try {
            $this->db->where('status <> 3');
            $this->db->where('pegawai_id', $this->session->userdata('pegawai_id'));
            return $this->db->get('register_permohonan');
        } catch (Exception $e) {
            return 0;
        }
    }

    public function simpan_data($tabel, $data)
    {
        try {
            $this->db->insert($tabel, $data);
            $title = "Simpan Data <br />Update tabel <b>" . $tabel . "</b>[]";
            $descrip = null;
            $this->add_audittrail("INSERT", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function simpan_permohonan($tabel, $data)
    {
        try {
            $this->db->insert($tabel, $data);
            $insert_id = $this->db->insert_id();
            $title = "Simpan Data <br />Update tabel <b>" . $tabel . "</b>[]";
            $descrip = null;
            $this->add_audittrail("INSERT", $title, $tabel, $descrip);
            return $insert_id;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pembaharuan_data($tabel, $data, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            $this->db->update($tabel, $data);
            $title = "Pembaharuan Data <br />Update tabel <b>" . $tabel . "</b>[Pada kolom<b>" . $kolom_seleksi . "</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function proses_simpan_data_barang($data)
    {
        if ($data['id'] == "-1") {
            //buat data barang baru
            $dataBarang = array(
                "kode_barang" => $data['kode'],
                "nama_barang" => $data['nama'],
                "satuan_id" => $data['satuan'],
                "kategori_id" => $data['kategori'],
                "stok" => $data['stok'],
                "deskripsi" => $data['deskripsi'],
                "foto" => $data['foto'],
                "created_on" => date('Y-m-d H:i:s'),
                "created_by" => $this->session->userdata("fullname")
            );

            $queryBarang = $this->simpan_data('register_barang', $dataBarang);
        } else {
            $dataBarang = array(
                "kode_barang" => $data['kode'],
                "nama_barang" => $data['nama'],
                "satuan_id" => $data['satuan'],
                "kategori_id" => $data['kategori'],
                "stok" => $data['stok'],
                "deskripsi" => $data['deskripsi'],
                "modified_on" => date('Y-m-d H:i:s'),
                "modified_by" => $this->session->userdata("fullname")
            );

            if ($data['foto']) {
                $dataBarang['foto'] = $data['foto'];
            }

            $queryBarang = $this->pembaharuan_data('register_barang', $dataBarang, 'id', $data['id']);
        }

        if ($queryBarang == 1) {
            if ($data['id'] == '-1') {
                return ['status' => true, 'message' => 'Barang Berhasil di Tambahkan'];
            } else {
                return ['status' => true, 'message' => 'Barang Berhasil di Perbarui'];
            }
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan Barang, ' . $queryBarang];
        }
    }

    public function proses_tambah_keranjang($data)
    {
        $cek_keranjang = $this->get_seleksi_array('keranjang', ['pegawai_id' => $this->session->userdata('pegawai_id'), 'barang_id' => $data['id'], 'status' => '0']);
        if ($cek_keranjang->num_rows() > 0) {
            $jumlah = $cek_keranjang->row()->jumlah;
            $jumlah += $data['jumlah'];

            $id = $cek_keranjang->row()->id;
            $query = $this->pembaharuan_data('keranjang', $data, 'id', $id);

            $data['jumlah'] = $jumlah;
        } else {
            $data = array(
                "pegawai_id" => $this->session->userdata('pegawai_id'),
                "barang_id" => $data['id'],
                "jumlah" => $data['jumlah'],
                "created_on" => date('Y-m-d H:i:s'),
            );

            $query = $this->simpan_data('keranjang', $data);
        }

        if ($query == 1) {
            return ['status' => true, 'message' => 'Berhasil Tambah ke Keranjang'];
        } else {
            return ['status' => false, 'message' => 'Gagal Tambah Ke Keranjang, ' . $query];
        }
    }

    public function proses_checkout_barang($keranjang)
    {
        $this->db->trans_start();

        # 1. Simpan ke tabel register_permohonan
        $data_permohonan = [
            'pegawai_id' => $this->session->userdata('pegawai_id'),
            'status' => 0,
            'hapus' => 0,
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('fullname')
        ];

        # Ambil id auto increment terakhir
        $permohonan_id = $this->simpan_permohonan('register_permohonan', $data_permohonan);

        # 2. Simpan ke tabel register_detail_permohonan
        foreach ($keranjang as $item) {
            $barang_id = $this->get_seleksi_array('keranjang', ['id' => $item['id']])->row()->barang_id;
            $detail = [
                'permohonan_id' => $permohonan_id,
                'barang_id' => $barang_id,
                'jumlah' => $item['jumlah'],
                'status' => 0,
                'hapus' => 0
            ];

            $this->simpan_data('register_detail_permohonan', $detail);

            # Set Stok Reserved di tabel register_barang
            #$this->db->set('stok_reserved', 'stok_reserved + ' . (int) $item['jumlah'], FALSE)
            #    ->where('id', $barang_id)
            #    ->update('register_barang');

            # Opsional: hapus dari keranjang
            $this->db->set('status', '1')
                ->where('barang_id', $barang_id)
                ->where('status', '0')
                ->where('pegawai_id', $this->session->userdata('pegawai_id'))
                ->update('keranjang');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            return ['status' => false, 'message' => 'Gagal Checkout'];
        } else {
            $params = [
                'kolom_seleksi' => 'jab_id',
                'seleksi' => '10'
            ];

            $result = $this->apihelper->get('apiclient/get_data_pegawai_aktif', $params);
            if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                $tujuan = $result['response']['data']['id'];
            } else {
                $params = [
                    'kolom_seleksi' => 'plh_id_jabatan',
                    'seleksi' => '10'
                ];

                $result = $this->apihelper->get('apiclient/get_data_plh', $params);
                if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                    $tujuan = $result['response']['data']['pegawai_id'];
                }
            }

            $pesanWA = "Assalamualaikum Wr. Wb., Yth.\n";
            $pesanWA .= "Ada permohonan barang persediaan baru. Silakan lakukan validasi melalui ANANDA MS Banda Aceh.\n";
            $pesanWA .= "Demikian diinformasikan, Terima Kasih atas perhatian.";

            $dataNotif = array(
                'jenis_pesan' => 'barang',
                'id_pemohon' => $this->session->userdata('pegawai_id'),
                'pesan' => $pesanWA,
                'id_tujuan' => $tujuan,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->kirim_notif($dataNotif);

            return ['status' => true, 'message' => 'Berhasil Checkout'];
        }
    }

    public function proses_validasi_barang($data)
    {
        # die(var_dump($data));
        $this->db->trans_start();

        # Ambil id permohonan
        $permohonan_id = $data['permohonan_id'];

        # Pembaharuan Data pada tabel register_detail_permohonan
        foreach ($data['data_barang'] as $item) {

            if ($item['status'] == '1' && (!$item['jumlah_diberikan'] || $item['jumlah_diberikan'] == NULL)) {
                return ['status' => false, 'message' => 'Peringatan, Isian Jumlah Diberikan harus diisi'];
            }

            $id_detail = $item['detail_id'];
            $minta = $item['jum_minta'];
            $jumlah = $item['jumlah_diberikan'];
            $status = $item['status'];
            $keterangan = $item['keterangan'];

            $barang_id = $this->get_seleksi_array('register_detail_permohonan', ['id' => $id_detail])->row()->barang_id;

            if ($item['status'] == '1' && ($jumlah > $minta)) {
                return ['status' => false, 'message' => 'Peringatan, Jumlah diberikan tidak boleh lebih dari jumlah yang diminta'];
            }

            if ($status == '1') {
                $detail['jumlah'] = $jumlah;

                if ($this->session->userdata('jab_id') == '5')
                    $detail['status'] = $status;

                if ($keterangan)
                    $detail['keterangan'] = $keterangan;

                #$jum_reserved = $minta - $jumlah;
                # Set Stok Reserved di tabel register_barang
                #$this->db->set('stok_reserved', 'stok_reserved - ' . (int) $jum_reserved, FALSE)
                #    ->where('id', $barang_id)
                #    ->update('register_barang');
            } else {
                $detail['status'] = $status;

                if ($keterangan)
                    $detail['keterangan'] = $keterangan;

                # Set Stok Reserved di tabel register_barang
                #$this->db->set('stok_reserved', 'stok_reserved - ' . (int) $minta, FALSE)
                #    ->where('id', $barang_id)
                #    ->update('register_barang');
            }

            if ($status == '2' && (!$keterangan || $keterangan == NULL)) {
                return ['status' => false, 'message' => 'Peringatan, Jika Status Ditolak, berikan keterangan'];
            }

            $this->pembaharuan_data('register_detail_permohonan', $detail, 'id', $id_detail);
        }

        # Update Data Permohonan
        $pejabat = $this->session->userdata('jab_id');
        if ($pejabat == '10') {
            $status = '1';
            $level = 'Kasub';
        } else {
            $status = '2';
            $level = 'Sekretaris';
        }

        $data_validasi = [
            'status' => $status,
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        ];

        $this->pembaharuan_data('register_permohonan', $data_validasi, 'id', $permohonan_id);

        $data_approval = [
            'permohonan_id' => $permohonan_id,
            'approver_id' => $this->session->userdata('userid'),
            'level' => $level,
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('fullname')
        ];

        $this->simpan_data('register_approval', $data_approval);

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            return ['status' => false, 'message' => 'Validasi gagal, periksa kembali isian anda atau hubungi Bagian IT'];
        } else {
            if ($pejabat == '10') {
                # Validasi Kasub Umum
                $params = [
                    'kolom_seleksi' => 'jab_id',
                    'seleksi' => '5'
                ];

                $result = $this->apihelper->get('apiclient/get_data_pegawai_aktif', $params);
                if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                    $tujuan = $result['response']['data']['id'];
                } else {
                    $params = [
                        'kolom_seleksi' => 'plh_id_jabatan',
                        'seleksi' => '5'
                    ];

                    $result = $this->apihelper->get('apiclient/get_data_plh', $params);
                    if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
                        $tujuan = $result['response']['data']['pegawai_id'];
                    }
                }

                $pesanWA = "Assalamualaikum Wr. Wb., Yth.\n";
                $pesanWA .= "Ada permohonan barang persediaan baru yang sudah divalidasi Bagian Umum Keuangan. Silakan lakukan validasi melalui ANANDA MS Banda Aceh.\n";
                $pesanWA .= "Demikian diinformasikan, Terima Kasih atas perhatian.";

                $dataNotif = array(
                    'jenis_pesan' => 'barang',
                    'id_pemohon' => $this->session->userdata('pegawai_id'),
                    'pesan' => $pesanWA,
                    'id_tujuan' => $tujuan,
                    'created_by' => $this->session->userdata('fullname'),
                    'created_on' => date('Y-m-d H:i:s')
                );

                $this->kirim_notif($dataNotif);
            } else {
                # Validasi Sekretaris
                $operator = $this->get_seleksi_array('peran', ['role' => 'operator'])->result_array();

                $pesanWA = "Assalamualaikum Wr. Wb., Yth.\n";
                $pesanWA .= "Ada permohonan barang persediaan baru yang sudah divalidasi. Silakan antarkan barang sesuai permohonan Pegawai yang sudah tervalidasi.\n";
                $pesanWA .= "Demikian diinformasikan, Terima Kasih atas perhatian.";

                foreach ($operator as $petugas) {
                    $dataNotif = array(
                        'jenis_pesan' => 'barang',
                        'id_pemohon' => $this->session->userdata('pegawai_id'),
                        'pesan' => $pesanWA,
                        'id_tujuan' => $petugas['pegawai_id'],
                        'created_by' => $this->session->userdata('fullname'),
                        'created_on' => date('Y-m-d H:i:s')
                    );

                    $this->kirim_notif($dataNotif);
                }

                $tujuan = $this->get_seleksi_array('register_permohonan', ['id' => $permohonan_id])->row()->pegawai_id;

                $pesan = "Assalamualaikum Wr. Wb., Yth.\n";
                $pesan .= "Permohonan sudah divalidasi. Silakan tunggu barang diantar oleh Petugas Barang Persediaan.\n";
                $pesan .= "Demikian diinformasikan, Terima Kasih atas perhatian.";

                $dataNotifPemohon = array(
                    'jenis_pesan' => 'barang',
                    'id_pemohon' => $this->session->userdata('pegawai_id'),
                    'pesan' => $pesan,
                    'id_tujuan' => $tujuan,
                    'created_by' => $this->session->userdata('fullname'),
                    'created_on' => date('Y-m-d H:i:s')
                );

                $this->kirim_notif($dataNotifPemohon);
            }

            return ['status' => true, 'message' => 'Validasi Berhasil'];
        }
    }

    public function proses_konfirmasi_permohonan($data)
    {
        # die(var_dump($data));
        $this->db->trans_start();

        # Ambil id permohonan
        $permohonan_id = $data['permohonan_id'];

        # Pembaharuan Data pada tabel register_detail_permohonan
        foreach ($data['data_barang'] as $item) {

            $id_detail = $item['detail_id'];
            $minta = $item['jum_minta'];

            $barang_id = $this->get_seleksi_array('register_detail_permohonan', ['id' => $id_detail])->row()->barang_id;

            # Set Stok Reserved di tabel register_barang
            #$this->db->set('stok_reserved', 'stok_reserved - ' . (int) $minta, FALSE)
            #    ->where('id', $barang_id)
            #    ->update('register_barang');

            # Set Stok di tabel register_barang
            $this->db->set('stok', 'stok - ' . (int) $minta, FALSE)
                ->where('id', $barang_id)
                ->update('register_barang');

            $data_riwayat_stok = [
                'barang_id' => $barang_id,
                'tipe' => 'keluar',
                'jumlah' => $minta,
                'keterangan' => 'Permohonan Barang Persediaan oleh Pegawai',
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            ];

            $this->simpan_data('riwayat_stok', $data_riwayat_stok);
        }

        # Set Status Permohonan di tabel register_permohonan
        $this->db->set('status', '3')
            ->where('id', $permohonan_id)
            ->update('register_permohonan');

        $data_approval = [
            'permohonan_id' => $permohonan_id,
            'approver_id' => $this->session->userdata('userid'),
            'level' => $this->session->userdata('peran'),
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('fullname')
        ];

        $this->simpan_data('register_approval', $data_approval);

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            return ['status' => false, 'message' => 'Konfirmasi gagal, periksa kembali data anda atau hubungi Bagian IT'];
        } else {
            return ['status' => true, 'message' => 'Konfirmasi Penyerahan Barang Berhasil'];
        }
    }

    public function proses_update_stok_barang($data)
    {
        $this->db->trans_start();

        $barang_id = $data['id'];
        $stok = $data['stok'];
        # Set Stok Reserved di tabel register_barang
        $this->db->set('stok', 'stok + ' . (int) $stok, FALSE)
            ->where('id', $barang_id)
            ->update('register_barang');

        $dataBarang = [
            'barang_id' => $barang_id,
            'tipe' => 'masuk',
            'jumlah' => $stok,
            'keterangan' => 'Update Stok Barang',
            'created_by' => $this->session->userdata('fullname'),
            'created_on' => date('Y-m-d H:i:s')
        ];

        $this->simpan_data('riwayat_stok', $dataBarang);

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            return ['status' => false, 'message' => 'Update stok gagal, periksa kembali isian anda atau hubungi Bagian IT'];
        } else {
            return ['status' => true, 'message' => 'Stok Barang Berhasil di Perbarui'];
        }
    }

    public function proses_simpan_ambil_barang($data)
    {
        $id = $data['id'];
        $barang_id = $data['barang_id'];
        $jumlah = $data['jumlah'];

        if ($id == '-1') {
            $data = [
                'pegawai_id' => $this->session->userdata('pegawai_id'),
                'barang_id' => $barang_id,
                'jumlah' => $jumlah,
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('fullname')
            ];

            $data_transaksi = [
                'barang_id' => $barang_id,
                'tipe' => 'keluar',
                'jumlah' => $jumlah,
                'keterangan' => 'Pegawai Ambil Barang dari Lemari Persediaan',
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('fullname')
            ];

            $this->db->trans_start();

            $this->simpan_data('register_ambil_barang', $data);
            $this->simpan_data('riwayat_stok', $data_transaksi);

            $this->db->set('stok', 'stok - ' . (int) $jumlah, FALSE)
                ->where('id', $barang_id)
                ->update('register_barang');

            $this->db->trans_complete();
        }

        if ($this->db->trans_status() == FALSE) {
            return ['status' => false, 'message' => 'Simpan Formulir Ambil Barang, periksa kembali isian anda atau hubungi Bagian IT'];
        } else {
            return ['status' => true, 'message' => 'Simpan Formulir Ambil Barang Berhasil, Stok Barang Berhasil di Perbarui'];
        }

    }

    /**
     * Get semua permohonan barang (untuk admin dan operator)
     * @return object Query result
     */
    public function get_all_permohonan()
    {
        try {
            $this->db->where('hapus', '0');
            $this->db->order_by('created_on', 'DESC');
            return $this->db->get('register_permohonan');
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Get semua data ambil barang (untuk admin dan operator)
     * @return object Query result
     */
    public function get_all_ambil_barang()
    {
        try {
            $this->db->order_by('created_on', 'DESC');
            return $this->db->get('register_ambil_barang');
        } catch (Exception $e) {
            return 0;
        }
    }
}