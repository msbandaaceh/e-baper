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
            if ($data['foto']) {
                $dataRapat = array(
                    "foto" => $data['foto'],
                );
            }
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
                return ['status' => false, 'message' => 'Gagal Tambah Ke Keranjang, Anda sudah menambah sejumlah '.$jumlah_keranjang.' di keranjang. Tidak boleh melebihi Stok Barang'];
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
}