<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/icon/e-baper.ico" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    <link href="assets/plugins/notifications/css/lobibox.min.css" rel="stylesheet" />
    <link href="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">

    <title><?= $this->session->userdata('nama_client_app') ?> | <?= $this->session->userdata('deskripsi_client_app') ?>
    </title>
    <style>
        /* Hover untuk nav-item dropdown */
        @media (min-width: 992px) {

            /* Hover untuk nav-item dropdown di desktop */
            .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
    </style>
</head>

<body class="bg-theme bg-theme3">
    <!--wrapper-->
    <div class="wrapper">
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="topbar-logo-header">
                        <div class="">
                            <img src="assets/images/e-baper.webp" class="logo-icon" alt="logo icon">
                        </div>
                        <div class="">
                            <h4 class="logo-text">ANANDA</h4>
                        </div>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <h3 class="logo-text">Aplikasi Permohonan dan Administrasi Barang Persediaan</h3>
                        </div>
                    </div>
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>

                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Click for Setting"> <i
                                        class='bx bx-category'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="row row-cols-3 g-3 p-3">
                                        <?php
                                        if (in_array($peran, ['admin'])) {
                                            ?>
                                            <div class="col text-center">
                                                <div class="app-box mx-auto bg-gradient-kyoto text-white"><i
                                                        class='bx bx-group' onclick="ModalRole('-1')"></i>
                                                </div>
                                                <div class="app-title">Peran</div>
                                            </div>
                                        <?php }

                                        if (in_array($peran, ['admin', 'operator'])) { ?>
                                            <div class="col text-center">
                                                <div class="app-box mx-auto bg-gradient-cosmic text-white"><i
                                                        class='bx bx-collection' onclick="ModalKategori('-1')"></i>
                                                </div>
                                                <div class="app-title">Kategori</div>
                                            </div>
                                            <div class="col text-center">
                                                <div class="app-box mx-auto bg-gradient-moonlit text-white"><i
                                                        class='bx bx-cabinet' onclick="ModalSatuan('-1')"></i>
                                                </div>
                                                <div class="app-title">Satuan</div>
                                            </div>
                                            <div class="col text-center">
                                                <div class="app-box mx-auto bg-gradient-burning text-white"><i
                                                        class='bx bx-package' data-page="data_barang"></i>
                                                </div>
                                                <div class="app-title">Barang</div>
                                            </div>
                                        <?php } ?>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-blues text-white"><a
                                                    href="<?= site_url('ambil_barang') ?>"><i
                                                        class='bx bx-collection'></i></a>
                                            </div>
                                            <div class="app-title">Lemari Persediaan</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-cosmic text-white"><i
                                                    class='bx bx-history' data-page="riwayat_permintaan"></i>
                                            </div>
                                            <div class="app-title">Riwayat Permintaan</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-lush text-white"><i
                                                    class='bx bx-book-open' data-page="panduan_penggunaan"></i>
                                            </div>
                                            <div class="app-title">Panduan</div>
                                        </div>
                                        <?php if (in_array($peran, ['admin', 'operator'])) { ?>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-ohhappiness text-white"><i
                                                    class='bx bx-file' data-page="register_permohonan"></i>
                                            </div>
                                            <div class="app-title">Register Permohonan</div>
                                        </div>
                                        <?php } ?>
                                        <?php if (in_array($peran, ['admin'])) { ?>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-kyoto text-white"><i
                                                    class='bx bx-code-alt' data-page="dokumentasi_teknis"></i>
                                            </div>
                                            <div class="app-title">Dokumentasi</div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div id="countKeranjang"></div>
                                    <i class='bx bx-cart'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div>
                                        <div class="msg-header">
                                            <p class="msg-header-title"><i class="bx bx-cart p-0 font-22"></i>Keranjang
                                            </p>
                                        </div>
                                    </div>
                                    <div class="header-notifications-list" id="keranjang-ikon">
                                    </div>
                                    <a href="javascript:;" data-page="keranjang">
                                        <div class="text-center msg-footer">Lihat Keranjang</div>
                                    </a>
                                </div>
                            </li>

                            <?php
                            if (in_array($peran, ['admin'])) {
                                ?>
                                <li class="nav-item dropdown dropdown-large">
                                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="javascript:;"
                                        data-page="validasi" role="button">
                                        <div id="countValidasi"></div>
                                        <i class='bx bx-task'></i>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php
                            if (in_array($peran, ['operator'])) {
                                ?>
                                <li class="nav-item dropdown dropdown-large">
                                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="javascript:;"
                                        data-page="permohonan_valid" role="button">
                                        <div id="countValid"></div>
                                        <i class='bx bx-task'></i>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $this->session->userdata('foto') ?>" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?= $this->session->userdata('fullname') ?></p>
                                <p class="designattion mb-0"><?= $this->session->userdata('jabatan') ?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="keluar"><i
                                        class='bx bx-log-out-circle'></i><span>Keluar</span></a>
                            </li>
                        </ul>
                    </div>

                </nav>
            </div>
        </header>
        <!--end header -->

        <div class="nav-container">
            <div class="mobile-topbar-header">
                <div>
                    <img src="assets/images/e-baper.webp" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">ANANDA</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <nav class="topbar-nav">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="javascript:;" data-page="dashboard">
                            <div class="parent-icon"><i class='bx bx-home-circle'></i>
                            </div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-page="panduan_penggunaan">
                            <div class="parent-icon"><i class='bx bx-book-open'></i>
                            </div>
                            <div class="menu-title">Panduan Penggunaan</div>
                        </a>
                    </li>
                    <?php if (in_array($peran, ['admin'])) { ?>
                    <li>
                        <a href="javascript:;" data-page="dokumentasi_teknis">
                            <div class="parent-icon"><i class='bx bx-code-alt'></i>
                            </div>
                            <div class="menu-title">Dokumentasi Teknis</div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

        <div id="app"></div>

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
    </div>

    <div class="modal fade" id="role-pegawai" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="card card-default">
                <div class="modal-content bg-success">
                    <div class="overlay" id="overlay">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul">Daftar Petugas</h5>
                    </div>
                    <form method="POST" id="formPeran">
                        <input type="hidden" id="id" name="id">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class="form-label">Pilih Pegawai</label>
                                <div id="pegawai_">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pilih Peran</label>
                                <div id="peran_"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light">Simpan</button>
                            <button type="button" id="btnBatal" onclick="ModalRole('-1')"
                                class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                    <div class="modal-body" id="tabel-role"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="kategori-barang" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="card card-default">
                <div class="modal-content bg-success">
                    <div class="overlay" id="overlay">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul">Daftar Kategori Barang</h5>
                    </div>
                    <form method="POST" id="formKategori">
                        <input type="hidden" id="id_kategori" name="id">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama"
                                    autocomplete="off" placeholder="Masukkan Nama Kategori">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light">Simpan</button>
                            <button type="button" id="btnKategoriBatal" onclick="ModalKategori('-1')"
                                class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                    <div class="modal-body" id="tabel-kategori"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="satuan-barang" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="card card-default">
                <div class="modal-content bg-success">
                    <div class="overlay" id="overlay">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul">Daftar Satuan Barang</h5>
                    </div>
                    <form method="POST" id="formSatuan">
                        <input type="hidden" id="id_satuan" name="id">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Satuan</label>
                                <input type="text" class="form-control" id="nama_satuan" name="nama"
                                    placeholder="Masukkan Nama Satuan" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light">Simpan</button>
                            <button type="button" id="btnSatuanBatal" onclick="ModalSatuan('-1')"
                                class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                    <div class="modal-body" id="tabel-satuan"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--end wrapper-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>

    <!--app JS-->
    <script src="assets/js/app.js"></script>

    <?php
    if ($this->session->flashdata('info')) {
        $result = $this->session->flashdata('info');
        if ($result == '1') {
            $pesan = $this->session->flashdata('pesan_sukses');
        } elseif ($result == '2') {
            $pesan = $this->session->flashdata('pesan_gagal');
        } else {
            $pesan = $this->session->flashdata('pesan_gagal');
        }
    } else {
        $result = "-1";
        $pesan = "";
    }
    ?>

    <script>
        $(document).ready(function () {
            // Load page
            loadPage('dashboard');
            var peran = '<?= $this->session->userdata('peran') ?>';
            var role = '<?= $this->session->userdata('role') ?>';

            // Navigasi SPA
            $('[data-page]').on('click', function (e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadPage(page);

                // tutup dropdown jika mode mobile
                if (window.innerWidth < 992) {
                    var dropdownToggle = $(this).closest('.dropdown').find('[data-bs-toggle="dropdown"]');
                    if (dropdownToggle.length) {
                        bootstrap.Dropdown.getInstance(dropdownToggle[0]).hide();
                    }
                }

                //load ikon keranjang
                loadNotifKeranjang();
                if (peran == 'admin' && role != 'super')
                    loadNotifValidasi();
                else if (peran == 'operator')
                    loadNotifValid();
            });

            //load ikon keranjang
            loadNotifKeranjang();
            if (peran == 'admin' && role != 'super')
                loadNotifValidasi();
            else if (peran == 'operator')
                loadNotifValid();
        });
    </script>

    <script type="text/javascript">
        var config = {
            peran: '<?= $peran ?>',
            userid: '<?= $this->session->userdata('userid') ?>',
            ipServer: '<?= $this->session->userdata('ip_satker') ?>',
            isMobile: '<?= $this->agent->is_mobile() ?>',
            tokenNow: '<?= $this->session->userdata("token_now") ?>',
            tokenCookies: '<?= $this->input->cookie('presensi_token', TRUE) ?>',
            result: '<?= $result ?>',
            pesan: '<?= $pesan ?>'
        };
    </script>

    <script src="assets/js/barang.js"></script>
</body>

</html>