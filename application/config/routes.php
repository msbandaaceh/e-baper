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

$route['show_kategori'] = 'HalamanBarang/show_kategori';
$route['simpan_kategori'] = 'HalamanBarang/simpan_kategori';

$route['show_satuan'] = 'HalamanBarang/show_satuan';
$route['simpan_satuan'] = 'HalamanBarang/simpan_satuan';

# ROUTE PROSES PERAN
$route['show_role'] = 'HalamanUtama/show_role';
$route['simpan_peran'] = 'HalamanUtama/simpan_peran';
$route['blok_peran'] = 'HalamanUtama/blok_peran';
$route['aktif_peran'] = 'HalamanUtama/aktif_peran';

$route['keluar'] = 'HalamanUtama/keluar';
