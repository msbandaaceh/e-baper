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
        .nav-item.dropdown:hover>.dropdown-menu {
            display: block;
            margin-top: 0;
            /* biar menempel */
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

                    <div class="top-menu ms-auto">

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
                            <li><a class="dropdown-item" href="<?= site_url() ?>"><i
                                        class='bx bx-home-circle'></i><span>Beranda</span></a>
                            </li>
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
            </div>
        </div>

        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">ANANDA</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Ambil Barang Lemari</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <h6 class="mb-0 text-uppercase">AMBIL BARANG PERSEDIAAN</h6>
                <hr />

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-light mb-3 mb-lg-0" data-bs-toggle="modal"
                                            data-bs-target="#ambil-barang"
                                            onclick="ambilBarang('<?= base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                                                class="bx bxs-plus-square"></i>Ambil Barang</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="tabelAmbilBarang"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
    </div>

    <div class="modal fade" id="ambil-barang" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="card card-default">
                <div class="modal-content bg-success">
                    <div class="overlay" id="overlay">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <form method="POST" id="formAmbilBarang">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judul">Form Ambil Barang Lemari</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group mb-3">
                                <label class="form-label">Pilih Barang</label>
                                <div id="barang_">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" placeholder="Masukkan Jumlah.."
                                    autocomplete="off" name="jumlah">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light">Simpan</button>
                        </div>
                    </form>
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
            loadTabelAmbilBarang();
        });
    </script>

    <script type="text/javascript">
        var config = {
            peran: '<?= $peran ?>',
            userid: '<?= $this->session->userdata('userid') ?>',
            result: '<?= $result ?>',
            pesan: '<?= $pesan ?>'
        };
    </script>

    <script src="assets/js/barang.js"></script>
</body>

</html>