<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'HalamanUtama';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['cek_token'] = 'HalamanUtama/cek_token_sso';

$route['show_barang'] = 'HalamanBarang/show_barang';
$route['show_daftar_barang'] = 'HalamanBarang/show_daftar_barang';
$route['show_daftar_barang_kategori'] = 'HalamanBarang/show_daftar_barang_kategori';
$route['simpan_barang'] = 'HalamanBarang/simpan_barang';
$route['hapus_barang'] = 'HalamanBarang/hapus_barang';

$route['show_daftar_keranjang'] = 'HalamanBarang/show_daftar_keranjang';
$route['tambah_keranjang'] = 'HalamanBarang/tambah_keranjang';
$route['update_jumlah_barang_keranjang'] = 'HalamanBarang/update_jumlah_barang_keranjang';
$route['hapus_keranjang'] = 'HalamanBarang/hapus_keranjang';
$route['checkout'] = 'HalamanBarang/checkout';

$route['show_kategori'] = 'HalamanBarang/show_kategori';
$route['simpan_kategori'] = 'HalamanBarang/simpan_kategori';

$route['show_satuan'] = 'HalamanBarang/show_satuan';
$route['simpan_satuan'] = 'HalamanBarang/simpan_satuan';

$route['show_tabel_validasi'] = 'HalamanValidasi/show_tabel_validasi';
$route['show_detail_permohonan'] = 'HalamanValidasi/show_detail_permohonan';
$route['simpan_validasi'] = 'HalamanValidasi/simpan_validasi';

$route['show_permohonan_valid'] = 'HalamanValidasi/show_tabel_validasi';
$route['show_detail_permohonan_valid'] = 'HalamanValidasi/show_detail_permohonan_valid';
$route['simpan_konfirmasi'] = 'HalamanValidasi/simpan_konfirmasi';

# ROUTE PROSES PERAN
$route['show_role'] = 'HalamanUtama/show_role';
$route['simpan_peran'] = 'HalamanUtama/simpan_peran';
$route['blok_peran'] = 'HalamanUtama/blok_peran';
$route['aktif_peran'] = 'HalamanUtama/aktif_peran';

$route['keluar'] = 'HalamanUtama/keluar';
