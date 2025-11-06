<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Dokumentasi Teknis</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bx bx-code-alt me-2"></i>Dokumentasi Teknis Sistem</h4>
                        <p class="text-muted mb-0">Informasi teknis tentang arsitektur, database, dan pengembangan sistem</p>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class="bx bx-lock"></i></div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-0 text-white">Akses Terbatas</h6>
                                    <div class="text-white">Dokumentasi ini hanya dapat diakses oleh Administrator</div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="accordionTeknis">
                            <!-- Arsitektur Sistem -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingArchitecture">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArchitecture" aria-expanded="true" aria-controls="collapseArchitecture">
                                        <i class="bx bx-architecture me-2"></i>Arsitektur Sistem
                                    </button>
                                </h2>
                                <div id="collapseArchitecture" class="accordion-collapse collapse show" aria-labelledby="headingArchitecture" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Framework dan Teknologi</h6>
                                        <ul>
                                            <li><strong>Framework:</strong> CodeIgniter 3.x</li>
                                            <li><strong>PHP Version:</strong> 7.4+</li>
                                            <li><strong>Database:</strong> MySQL/MariaDB</li>
                                            <li><strong>Frontend:</strong> Bootstrap 5, jQuery, MetisMenu</li>
                                            <li><strong>PDF Library:</strong> DomPDF</li>
                                        </ul>

                                        <h6 class="mt-3">Struktur Direktori</h6>
                                        <pre class="bg-light p-3 rounded"><code>application/
├── controllers/     # Controller utama
├── models/          # Model database
├── views/           # Template view
├── core/            # MY_Controller (base controller)
├── libraries/       # Custom libraries
└── config/          # Konfigurasi

assets/
├── css/             # Stylesheet
├── js/              # JavaScript
├── images/          # Gambar
└── plugins/         # Plugin pihak ketiga</code></pre>
                                    </div>
                                </div>
                            </div>

                            <!-- Database -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingDatabase">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDatabase" aria-expanded="false" aria-controls="collapseDatabase">
                                        <i class="bx bx-data me-2"></i>Struktur Database
                                    </button>
                                </h2>
                                <div id="collapseDatabase" class="accordion-collapse collapse" aria-labelledby="headingDatabase" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Tabel Utama</h6>
                                        <ul>
                                            <li><strong>register_barang</strong> - Master data barang</li>
                                            <li><strong>register_permohonan</strong> - Header permohonan</li>
                                            <li><strong>register_detail_permohonan</strong> - Detail barang permohonan</li>
                                            <li><strong>register_ambil_barang</strong> - Pengambilan barang langsung</li>
                                            <li><strong>register_approval</strong> - Riwayat approval</li>
                                            <li><strong>keranjang</strong> - Keranjang belanja</li>
                                            <li><strong>peran</strong> - Role pegawai</li>
                                            <li><strong>ref_kategori</strong> - Master kategori</li>
                                            <li><strong>ref_satuan</strong> - Master satuan</li>
                                            <li><strong>riwayat_stok</strong> - Riwayat perubahan stok</li>
                                        </ul>

                                        <h6 class="mt-3">Relasi Utama</h6>
                                        <ul>
                                            <li>register_barang → ref_kategori (kategori_id)</li>
                                            <li>register_barang → ref_satuan (satuan_id)</li>
                                            <li>register_permohonan → pegawai (pegawai_id)</li>
                                            <li>register_detail_permohonan → register_permohonan (permohonan_id)</li>
                                            <li>register_detail_permohonan → register_barang (barang_id)</li>
                                            <li>register_approval → register_permohonan (permohonan_id)</li>
                                        </ul>

                                        <h6 class="mt-3">View Database</h6>
                                        <ul>
                                            <li><strong>v_register_barang</strong> - View barang dengan join kategori dan satuan</li>
                                            <li><strong>v_keranjang</strong> - View keranjang dengan detail barang</li>
                                            <li><strong>v_ambil_barang</strong> - View pengambilan barang</li>
                                            <li><strong>v_detail_permohonan</strong> - View detail permohonan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Autentikasi dan Autorisasi -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAuth">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuth" aria-expanded="false" aria-controls="collapseAuth">
                                        <i class="bx bx-shield me-2"></i>Autentikasi dan Autorisasi
                                    </button>
                                </h2>
                                <div id="collapseAuth" class="accordion-collapse collapse" aria-labelledby="headingAuth" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Sistem Autentikasi</h6>
                                        <ul>
                                            <li>Menggunakan SSO (Single Sign-On) terpusat</li>
                                            <li>Token disimpan dalam cookie (sso_token)</li>
                                            <li>Validasi token dilakukan melalui API SSO</li>
                                            <li>Session management menggunakan CodeIgniter Session</li>
                                        </ul>

                                        <h6 class="mt-3">Sistem Role</h6>
                                        <ul>
                                            <li><strong>admin</strong> - Administrator sistem
                                                <ul>
                                                    <li>Akses penuh ke semua fitur</li>
                                                    <li>Manajemen peran pegawai</li>
                                                    <li>Validasi permohonan</li>
                                                </ul>
                                            </li>
                                            <li><strong>operator</strong> - Operator Persediaan
                                                <ul>
                                                    <li>Manajemen barang, kategori, satuan</li>
                                                    <li>Konfirmasi penyerahan barang</li>
                                                    <li>Pengambilan dari lemari persediaan</li>
                                                </ul>
                                            </li>
                                            <li><strong>pegawai</strong> - Pegawai biasa
                                                <ul>
                                                    <li>Permohonan barang</li>
                                                    <li>Melihat riwayat permohonan</li>
                                                    <li>Pengambilan dari lemari persediaan</li>
                                                </ul>
                                            </li>
                                        </ul>

                                        <h6 class="mt-3">Cek Role di Controller</h6>
                                        <pre class="bg-light p-3 rounded"><code>// Di MY_Controller
$peran = $this->session->userdata('peran');

// Cek akses
if (in_array($peran, ['admin'])) {
    // Kode untuk admin
}

if (in_array($peran, ['admin', 'operator'])) {
    // Kode untuk admin dan operator
}</code></pre>
                                    </div>
                                </div>
                            </div>

                            <!-- API Integration -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAPI">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAPI" aria-expanded="false" aria-controls="collapseAPI">
                                        <i class="bx bx-api me-2"></i>Integrasi API
                                    </button>
                                </h2>
                                <div id="collapseAPI" class="accordion-collapse collapse" aria-labelledby="headingAPI" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>API yang Digunakan</h6>
                                        <ul>
                                            <li><strong>SSO API</strong> - Validasi token dan data user</li>
                                            <li><strong>API Client</strong> - Mengakses data dari sistem lain
                                                <ul>
                                                    <li>get_data_seleksi - Mengambil data dengan filter</li>
                                                    <li>get_data_pegawai_aktif - Data pegawai aktif</li>
                                                    <li>get_data_plh - Data PLH (Pelaksana Harian)</li>
                                                    <li>simpan_data - Menyimpan data ke sistem lain</li>
                                                </ul>
                                            </li>
                                        </ul>

                                        <h6 class="mt-3">Library ApiHelper</h6>
                                        <p>Library custom untuk komunikasi dengan API eksternal. Terletak di <code>application/libraries/ApiHelper.php</code></p>
                                        <pre class="bg-light p-3 rounded"><code>// Contoh penggunaan
$params = [
    'tabel' => 'v_users',
    'kolom_seleksi' => 'userid',
    'seleksi' => $userid
];

$result = $this->apihelper->get('apiclient/get_data_seleksi', $params);</code></pre>
                                    </div>
                                </div>
                            </div>

                            <!-- Alur Proses Permohonan -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFlow">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFlow" aria-expanded="false" aria-controls="collapseFlow">
                                        <i class="bx bx-git-branch me-2"></i>Alur Proses Permohonan
                                    </button>
                                </h2>
                                <div id="collapseFlow" class="accordion-collapse collapse" aria-labelledby="headingFlow" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Status Permohonan</h6>
                                        <ol>
                                            <li><strong>0 - Menunggu Validasi</strong>
                                                <ul>
                                                    <li>Pegawai membuat permohonan (checkout)</li>
                                                    <li>Status di register_permohonan = 0</li>
                                                    <li>Notifikasi dikirim ke Kasub Umum Keuangan (jab_id = 10)</li>
                                                </ul>
                                            </li>
                                            <li><strong>1 - Disetujui Kasub</strong>
                                                <ul>
                                                    <li>Kasub menyetujui permohonan</li>
                                                    <li>Status di register_permohonan = 1</li>
                                                    <li>Notifikasi dikirim ke Sekretaris (jab_id = 5)</li>
                                                </ul>
                                            </li>
                                            <li><strong>2 - Disetujui Sekretaris</strong>
                                                <ul>
                                                    <li>Sekretaris menyetujui permohonan</li>
                                                    <li>Status di register_permohonan = 2</li>
                                                    <li>Notifikasi dikirim ke Operator dan Pemohon</li>
                                                </ul>
                                            </li>
                                            <li><strong>3 - Selesai</strong>
                                                <ul>
                                                    <li>Operator mengkonfirmasi penyerahan</li>
                                                    <li>Status di register_permohonan = 3</li>
                                                    <li>Stok barang dikurangi</li>
                                                </ul>
                                            </li>
                                        </ol>

                                        <h6 class="mt-3">Tabel Terkait</h6>
                                        <ul>
                                            <li><strong>register_permohonan</strong> - Header permohonan (status)</li>
                                            <li><strong>register_detail_permohonan</strong> - Detail barang (status per item)</li>
                                            <li><strong>register_approval</strong> - Riwayat approval (level, approver, tanggal)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload dan File Management -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingUpload">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpload" aria-expanded="false" aria-controls="collapseUpload">
                                        <i class="bx bx-upload me-2"></i>Upload dan File Management
                                    </button>
                                </h2>
                                <div id="collapseUpload" class="accordion-collapse collapse" aria-labelledby="headingUpload" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Konfigurasi Upload</h6>
                                        <ul>
                                            <li><strong>Path:</strong> assets/images/barang/</li>
                                            <li><strong>Allowed Types:</strong> PNG saja</li>
                                            <li><strong>Max Size:</strong> 5MB (5120 KB)</li>
                                            <li><strong>Encrypt Name:</strong> TRUE (nama file dienkripsi)</li>
                                        </ul>

                                        <h6 class="mt-3">Proses Upload</h6>
                                        <ol>
                                            <li>File diupload menggunakan CodeIgniter Upload Library</li>
                                            <li>File dienkripsi namanya</li>
                                            <li>Gambar dikompresi (quality 60%)</li>
                                            <li>File PNG dikonversi ke JPEG untuk kompresi</li>
                                            <li>Nama file disimpan di database (register_barang.foto)</li>
                                        </ol>

                                        <h6 class="mt-3">Kompresi Gambar</h6>
                                        <pre class="bg-light p-3 rounded"><code>// Fungsi kompresi di HalamanBarang
private function _compress_image($source_path, $destination_path, $quality = 25)
{
    // Menggunakan GD library
    // PNG dikonversi ke JPEG untuk kompresi
}</code></pre>
                                    </div>
                                </div>
                            </div>

                            <!-- Security -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSecurity">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurity" aria-expanded="false" aria-controls="collapseSecurity">
                                        <i class="bx bx-lock-alt me-2"></i>Keamanan
                                    </button>
                                </h2>
                                <div id="collapseSecurity" class="accordion-collapse collapse" aria-labelledby="headingSecurity" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Fitur Keamanan</h6>
                                        <ul>
                                            <li><strong>Encryption</strong> - ID dienkripsi menggunakan CodeIgniter Encryption
                                                <ul>
                                                    <li>ID dienkripsi dan di-encode base64 sebelum dikirim ke frontend</li>
                                                    <li>Didekripsi saat diterima di backend</li>
                                                </ul>
                                            </li>
                                            <li><strong>CSRF Protection</strong> - CodeIgniter CSRF protection aktif</li>
                                            <li><strong>Input Validation</strong> - Semua input divalidasi menggunakan Form Validation</li>
                                            <li><strong>Soft Delete</strong> - Data tidak dihapus, hanya ditandai hapus = 1</li>
                                            <li><strong>Audit Trail</strong> - Semua perubahan dicatat di sys_audittrail</li>
                                        </ul>

                                        <h6 class="mt-3">Contoh Enkripsi ID</h6>
                                        <pre class="bg-light p-3 rounded"><code>// Enkripsi (saat mengirim ke frontend)
$id_encrypted = base64_encode($this->encryption->encrypt($id));

// Dekripsi (saat menerima dari frontend)
$id = $this->encryption->decrypt(base64_decode($this->input->post('id')));</code></pre>
                                    </div>
                                </div>
                            </div>

                            <!-- Maintenance -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingMaintenance">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaintenance" aria-expanded="false" aria-controls="collapseMaintenance">
                                        <i class="bx bx-wrench me-2"></i>Maintenance dan Troubleshooting
                                    </button>
                                </h2>
                                <div id="collapseMaintenance" class="accordion-collapse collapse" aria-labelledby="headingMaintenance" data-bs-parent="#accordionTeknis">
                                    <div class="accordion-body">
                                        <h6>Log dan Error Handling</h6>
                                        <ul>
                                            <li><strong>Log Files:</strong> application/logs/</li>
                                            <li><strong>Error Display:</strong> Dapat dikonfigurasi di config.php</li>
                                            <li><strong>Database Error:</strong> Ditangani dengan try-catch</li>
                                        </ul>

                                        <h6 class="mt-3">Common Issues</h6>
                                        <ul>
                                            <li><strong>Token Expired:</strong> User harus login ulang</li>
                                            <li><strong>Upload Failed:</strong> Cek permission folder assets/images/barang/</li>
                                            <li><strong>Database Connection:</strong> Cek config/database.php</li>
                                            <li><strong>API Error:</strong> Cek koneksi ke API server dan API key</li>
                                        </ul>

                                        <h6 class="mt-3">Backup Database</h6>
                                        <p>Rekomendasi backup harian untuk tabel-tabel penting:</p>
                                        <ul>
                                            <li>register_barang</li>
                                            <li>register_permohonan</li>
                                            <li>register_detail_permohonan</li>
                                            <li>register_approval</li>
                                            <li>riwayat_stok</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

