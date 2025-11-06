<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Panduan Penggunaan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bx bx-book-open me-2"></i>Panduan Penggunaan Sistem</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $peran = $this->session->userdata('peran');
                        
                        if ($peran == 'admin') {
                            // Panduan untuk Admin
                            ?>
                            <div class="alert alert-info border-0 bg-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class="bx bx-info-circle"></i></div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 text-white">Panduan untuk Admin</h6>
                                        <div class="text-white">Anda sedang melihat panduan penggunaan untuk peran <strong>Administrator</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="accordionAdmin">
                                <!-- Bagian 1: Dashboard -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="bx bx-home-circle me-2"></i>Dashboard
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Dashboard</h6>
                                            <ul>
                                                <li>Melihat daftar barang yang tersedia di sistem</li>
                                                <li>Mencari barang berdasarkan nama atau kategori</li>
                                                <li>Menambahkan barang ke keranjang untuk permohonan</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Gunakan kotak pencarian untuk mencari barang spesifik</li>
                                                <li>Pilih kategori dari dropdown untuk filter barang</li>
                                                <li>Klik pada kartu barang untuk melihat detail dan menambah ke keranjang</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 2: Manajemen Barang -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="bx bx-package me-2"></i>Manajemen Barang
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Manajemen Barang</h6>
                                            <ul>
                                                <li>Menambah barang baru ke sistem</li>
                                                <li>Mengedit informasi barang yang sudah ada</li>
                                                <li>Menghapus barang (soft delete)</li>
                                                <li>Mengupdate stok barang</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menambah Barang:</h6>
                                            <ol>
                                                <li>Klik ikon <i class="bx bx-package"></i> pada menu aplikasi</li>
                                                <li>Klik tombol "Tambah Barang"</li>
                                                <li>Isi form: Kode Barang, Nama Barang, Deskripsi, Stok, Kategori, Satuan</li>
                                                <li>Upload foto barang (format PNG, maks 5MB)</li>
                                                <li>Klik "Simpan"</li>
                                            </ol>
                                            <h6 class="mt-3">Cara Update Stok:</h6>
                                            <ol>
                                                <li>Buka halaman Data Barang</li>
                                                <li>Klik tombol "Update Stok" pada barang yang ingin diupdate</li>
                                                <li>Masukkan jumlah stok yang akan ditambahkan</li>
                                                <li>Klik "Simpan"</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 3: Manajemen Kategori dan Satuan -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="bx bx-category me-2"></i>Kategori dan Satuan
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Manajemen Kategori dan Satuan</h6>
                                            <ul>
                                                <li>Menambah, mengedit, dan menghapus kategori barang</li>
                                                <li>Menambah, mengedit, dan menghapus satuan barang</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Klik ikon <i class="bx bx-category"></i> pada menu aplikasi</li>
                                                <li>Pilih "Kategori" atau "Satuan"</li>
                                                <li>Klik "Tambah" untuk membuat baru atau klik pada item untuk mengedit</li>
                                                <li>Isi nama kategori/satuan</li>
                                                <li>Klik "Simpan"</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 4: Manajemen Peran -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <i class="bx bx-group me-2"></i>Manajemen Peran Pegawai
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Manajemen Peran</h6>
                                            <ul>
                                                <li>Menunjuk pegawai sebagai Operator Persediaan</li>
                                                <li>Mengaktifkan atau menonaktifkan peran pegawai</li>
                                                <li>Melihat daftar pegawai yang memiliki peran</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menunjuk Operator:</h6>
                                            <ol>
                                                <li>Klik ikon <i class="bx bx-group"></i> pada menu aplikasi</li>
                                                <li>Klik "Tambah" untuk menunjuk operator baru</li>
                                                <li>Pilih pegawai dari dropdown</li>
                                                <li>Pilih peran "operator"</li>
                                                <li>Klik "Simpan" - Pegawai akan menerima notifikasi</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 5: Validasi Permohonan -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <i class="bx bx-task me-2"></i>Validasi Permohonan
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Validasi</h6>
                                            <ul>
                                                <li>Melihat daftar permohonan barang yang perlu divalidasi</li>
                                                <li>Menyetujui atau menolak permohonan</li>
                                                <li>Mengatur jumlah barang yang diberikan (jika berbeda dari permintaan)</li>
                                            </ul>
                                            <h6 class="mt-3">Proses Validasi:</h6>
                                            <ol>
                                                <li>Klik ikon notifikasi <i class="bx bx-task"></i> untuk melihat permohonan baru</li>
                                                <li>Klik pada permohonan untuk melihat detail</li>
                                                <li>Untuk setiap barang, pilih status:
                                                    <ul>
                                                        <li><strong>Disetujui</strong>: Masukkan jumlah yang diberikan</li>
                                                        <li><strong>Ditolak</strong>: Wajib isi keterangan penolakan</li>
                                                    </ul>
                                                </li>
                                                <li>Klik "Simpan Validasi"</li>
                                                <li>Sistem akan mengirim notifikasi ke pemohon dan pihak terkait</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 6: Riwayat -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <i class="bx bx-history me-2"></i>Riwayat Permintaan
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionAdmin">
                                        <div class="accordion-body">
                                            <h6>Fungsi Riwayat</h6>
                                            <ul>
                                                <li>Melihat semua permohonan yang pernah dibuat</li>
                                                <li>Melacak status permohonan (Menunggu, Disetujui, Ditolak, Selesai)</li>
                                                <li>Melihat detail barang yang dimohonkan</li>
                                                <li>Melihat riwayat approval</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } elseif ($peran == 'operator') {
                            // Panduan untuk Operator/Petugas
                            ?>
                            <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class="bx bx-info-circle"></i></div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 text-white">Panduan untuk Operator/Petugas</h6>
                                        <div class="text-white">Anda sedang melihat panduan penggunaan untuk peran <strong>Operator Persediaan</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="accordionOperator">
                                <!-- Bagian 1: Dashboard -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="bx bx-home-circle me-2"></i>Dashboard
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionOperator">
                                        <div class="accordion-body">
                                            <h6>Fungsi Dashboard</h6>
                                            <ul>
                                                <li>Melakukan pencarian barang</li>
                                                <li>Menambahkan barang ke keranjang untuk permohonan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 2: Manajemen Barang -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="bx bx-package me-2"></i>Manajemen Barang
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionOperator">
                                        <div class="accordion-body">
                                            <h6>Fungsi Manajemen Barang</h6>
                                            <p>Sebagai Operator, Anda dapat:</p>
                                            <ul>
                                                <li>Menambah barang baru ke sistem</li>
                                                <li>Mengedit informasi barang yang sudah ada</li>
                                                <li>Mengupdate stok barang</li>
                                                <li>Mengelola kategori dan satuan barang</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menambah Barang:</h6>
                                            <ol>
                                                <li>Klik ikon <i class="bx bx-package"></i> pada menu aplikasi</li>
                                                <li>Klik tombol "Tambah Barang"</li>
                                                <li>Isi semua field yang wajib diisi</li>
                                                <li>Upload foto barang (PNG, maks 5MB)</li>
                                                <li>Klik "Simpan"</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 3: Konfirmasi Penyerahan Barang -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="bx bx-task me-2"></i>Konfirmasi Penyerahan Barang
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionOperator">
                                        <div class="accordion-body">
                                            <h6>Fungsi Konfirmasi</h6>
                                            <ul>
                                                <li>Melihat permohonan yang sudah divalidasi</li>
                                                <li>Mengkonfirmasi penyerahan barang ke pegawai</li>
                                                <li>Sistem akan mengurangi stok otomatis setelah konfirmasi</li>
                                            </ul>
                                            <h6 class="mt-3">Proses Konfirmasi:</h6>
                                            <ol>
                                                <li>Klik ikon notifikasi <i class="bx bx-task"></i> untuk melihat permohonan yang perlu dikonfirmasi</li>
                                                <li>Klik pada permohonan untuk melihat detail</li>
                                                <li>Pastikan barang sudah diserahkan ke pegawai</li>
                                                <li>Klik "Konfirmasi Penyerahan"</li>
                                                <li>Stok barang akan otomatis berkurang</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 4: Lemari Persediaan -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <i class="bx bx-collection me-2"></i>Lemari Persediaan
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionOperator">
                                        <div class="accordion-body">
                                            <h6>Fungsi Lemari Persediaan</h6>
                                            <p>Digunakan untuk mencatat pengambilan barang langsung dari lemari persediaan tanpa melalui proses permohonan.</p>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Klik menu "Lemari Persediaan"</li>
                                                <li>Pilih barang yang diambil</li>
                                                <li>Masukkan jumlah yang diambil</li>
                                                <li>Klik "Simpan"</li>
                                                <li>Stok akan otomatis berkurang</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            // Panduan untuk Pegawai Biasa
                            ?>
                            <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class="bx bx-info-circle"></i></div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 text-white">Panduan untuk Pegawai</h6>
                                        <div class="text-white">Anda sedang melihat panduan penggunaan untuk <strong>Pegawai</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="accordionPegawai">
                                <!-- Bagian 1: Dashboard -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="bx bx-home-circle me-2"></i>Dashboard
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionPegawai">
                                        <div class="accordion-body">
                                            <h6>Fungsi Dashboard</h6>
                                            <ul>
                                                <li>Melihat daftar barang yang tersedia</li>
                                                <li>Mencari barang berdasarkan nama atau kategori</li>
                                                <li>Menambahkan barang ke keranjang untuk permohonan</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Gunakan kotak pencarian untuk mencari barang</li>
                                                <li>Pilih kategori dari dropdown untuk memfilter barang</li>
                                                <li>Klik pada kartu barang untuk melihat detail</li>
                                                <li>Masukkan jumlah yang diinginkan</li>
                                                <li>Klik "Tambahkan Ke Keranjang"</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 2: Keranjang -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="bx bx-cart me-2"></i>Keranjang
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionPegawai">
                                        <div class="accordion-body">
                                            <h6>Fungsi Keranjang</h6>
                                            <ul>
                                                <li>Melihat barang yang sudah ditambahkan ke keranjang</li>
                                                <li>Mengubah jumlah barang</li>
                                                <li>Menghapus barang dari keranjang</li>
                                                <li>Melakukan checkout untuk membuat permohonan</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Klik ikon keranjang <i class="bx bx-cart"></i> di header untuk melihat isi keranjang</li>
                                                <li>Atau klik menu "Keranjang" untuk melihat detail lengkap</li>
                                                <li>Ubah jumlah dengan klik tombol +/- atau ketik langsung</li>
                                                <li>Klik ikon sampah untuk menghapus barang</li>
                                                <li>Klik "Checkout" untuk membuat permohonan</li>
                                            </ol>
                                            <div class="alert alert-warning mt-3">
                                                <strong>Catatan:</strong> Anda tidak bisa checkout jika masih ada permohonan yang belum selesai.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 3: Permohonan Barang -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="bx bx-file me-2"></i>Permohonan Barang
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionPegawai">
                                        <div class="accordion-body">
                                            <h6>Proses Permohonan</h6>
                                            <p>Setelah checkout, permohonan akan melalui proses berikut:</p>
                                            <ol>
                                                <li><strong>Menunggu Validasi</strong> - Permohonan dikirim ke Kasub Umum Keuangan</li>
                                                <li><strong>Validasi Kasub</strong> - Kasub dapat menyetujui atau menolak</li>
                                                <li><strong>Validasi Sekretaris</strong> - Jika disetujui Kasub, dilanjutkan ke Sekretaris</li>
                                                <li><strong>Penyerahan Barang</strong> - Operator akan mengkonfirmasi penyerahan</li>
                                                <li><strong>Selesai</strong> - Permohonan selesai</li>
                                            </ol>
                                            <h6 class="mt-3">Status Permohonan:</h6>
                                            <ul>
                                                <li><span class="badge bg-warning">0</span> - Menunggu Validasi</li>
                                                <li><span class="badge bg-info">1</span> - Disetujui Kasub</li>
                                                <li><span class="badge bg-primary">2</span> - Disetujui Sekretaris</li>
                                                <li><span class="badge bg-success">3</span> - Selesai (Barang sudah diserahkan)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 4: Riwayat Permintaan -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <i class="bx bx-history me-2"></i>Riwayat Permintaan
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionPegawai">
                                        <div class="accordion-body">
                                            <h6>Fungsi Riwayat</h6>
                                            <ul>
                                                <li>Melihat semua permohonan yang pernah dibuat</li>
                                                <li>Melacak status permohonan</li>
                                                <li>Melihat detail barang yang dimohonkan</li>
                                                <li>Melihat riwayat approval dari Kasub dan Sekretaris</li>
                                            </ul>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Klik menu "Riwayat Permintaan"</li>
                                                <li>Klik pada item permohonan untuk melihat detail</li>
                                                <li>Detail akan menampilkan:
                                                    <ul>
                                                        <li>Tanggal permohonan</li>
                                                        <li>Daftar barang yang dimohonkan</li>
                                                        <li>Status setiap barang</li>
                                                        <li>Riwayat approval</li>
                                                    </ul>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 5: Lemari Persediaan -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <i class="bx bx-collection me-2"></i>Lemari Persediaan
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionPegawai">
                                        <div class="accordion-body">
                                            <h6>Fungsi Lemari Persediaan</h6>
                                            <p>Fitur ini digunakan untuk mengambil barang langsung dari lemari persediaan tanpa melalui proses permohonan.</p>
                                            <h6 class="mt-3">Cara Menggunakan:</h6>
                                            <ol>
                                                <li>Klik menu "Lemari Persediaan"</li>
                                                <li>Pilih barang yang akan diambil</li>
                                                <li>Masukkan jumlah</li>
                                                <li>Klik "Simpan"</li>
                                                <li>Barang akan langsung terambil dan stok berkurang</li>
                                            </ol>
                                            <div class="alert alert-info mt-3">
                                                <strong>Catatan:</strong> Pengambilan melalui lemari persediaan tidak memerlukan approval. Pastikan Anda sudah memiliki izin untuk mengambil barang tersebut.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

