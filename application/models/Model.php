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
            $dataRapat = array(
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

            $queryRapat = $this->simpan_data('register_barang', $dataRapat);
        } else {
            $dataRapat = array(
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
                $dataRapat['foto'] = $data['foto'];
            }

            $queryRapat = $this->pembaharuan_data('register_barang', $dataRapat, 'id', $data['id']);
        }

        if ($queryRapat == 1) {
            if ($data['id'] == '-1') {
                return ['status' => true, 'message' => 'Barang Berhasil di Tambahkan'];
            } else {
                return ['status' => true, 'message' => 'Barang Berhasil di Perbarui'];
            }
        } else {
            return ['status' => false, 'message' => 'Gagal Simpan Barang, ' . $queryRapat];
        }
    }

    public function proses_tambah_keranjang($data)
    {
        $cek_keranjang = $this->get_seleksi_array('keranjang', ['pegawai_id' => $this->session->userdata('pegawai_id'), 'barang_id' => $data['id'], 'status' => '0']);
        if ($cek_keranjang->num_rows() > 0) {
            $jumlah = $cek_keranjang->row()->jumlah;
            $jumlah_keranjang = $jumlah;
            $jumlah += $data['jumlah'];

            $cek_stok = $this->get_seleksi_array('v_register_barang', ['id' => $data['id']]);
            $stok = $cek_stok->row()->stok;

            if ($jumlah > $stok) {
                return ['status' => false, 'message' => 'Gagal Tambah Ke Keranjang, Anda sudah menambah sejumlah ' . $jumlah_keranjang . ' di keranjang. Tidak boleh melebihi Stok Barang'];
            } else {
                $id = $cek_keranjang->row()->id;
                $query = $this->pembaharuan_data('keranjang', $data, 'id', $id);
            }

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
            $this->db->set('stok_reserved', 'stok_reserved + ' . (int) $item['jumlah'], FALSE)
                ->where('id', $barang_id)
                ->update('register_barang');

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
            $pesanWA .= "Ada permohonan barang persediaan baru. Silakan lakukan validasi melalui E-BAPER.\n";
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
}