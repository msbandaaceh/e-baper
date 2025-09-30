<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <form class="float-lg-end">
                                    <div class="row row-cols-lg-auto g-2">
                                        <div class="col-12">
                                            <div class="position-relative">
                                                <input type="text" class="form-control ps-5" id="cariBarang"
                                                    placeholder="Cari Barang ..."> <span
                                                    class="position-absolute top-50 product-show translate-middle-y"><i
                                                        class="bx bx-search"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="btn-group" role="group"
                                                aria-label="Button group with nested dropdown">
                                                <button type="button" class="btn btn-light">Kategori Barang</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-light dropdown-toggle dropdown-toggle-nocaret px-1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bxs-category"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <?php foreach ($kategori as $item) { ?>
                                                            <li><a class="dropdown-item"
                                                                    onclick="daftarBarangDashboardKategori('<?= $item->id ?>')"><?= $item->nama_kategori ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="daftarBarang"></div>
    </div>
</div>

<div class="modal fade" id="tambah-keranjang" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" id="formTambahKeranjang" class="modal-content bg-success">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-user me-1 font-22"></i>
                </div>
                <h5 class="mb-0">DETAIL DATA BARANG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" class="form-control" id="id" name="id">
                </div>
                <div class="row g-0">
                    <div class="col-md-4 border-end">
                        <img id="preview" src="" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title" id="nama_barang"></h4>
                            <!--
                            <div class="d-flex gap-3 py-3">
                                <div class="text-white" id="stok_label"><i class="bx bxs-cart-alt align-middle"></i>
                                </div>
                                <input type="hidden" id="stok">
                            </div>
                            -->

                            <div class="mb-3">
                                <span>Deskripsi</span>
                            </div>
                            <p class="card-text fs-6" id="deskripsi"></p>

                            <hr>
                            <div class="row row-cols-auto row-cols-1 row-cols-md-3 align-items-center mb-3">
                                <div class="col">
                                    <label class="form-label">Jumlah</label>
                                    <div class="input-group input-spinner">
                                        <button class="btn btn-light" type="button" id="button-minus"> - </button>
                                        <input type="text" class="form-control" id="jumlah" name="jumlah">
                                        <button class="btn btn-light" type="button" id="button-plus"> + </button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-danger" id="stok_notif">
                            </div>
                            <div class="d-flex gap-3 mt-3">
                                <button type="submit" class="btn btn-light"><span class="text">Tambahkan Ke
                                        Keranjang</span> <i class="bx bxs-cart-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        loadDaftarBarangDashboard();

        document.getElementById("cariBarang").addEventListener("keyup", function () {
            let keyword = this.value.toLowerCase();
            let items = document.querySelectorAll("#daftar-barang .item-barang");

            items.forEach(function (item) {
                let title = item.querySelector(".card-title").textContent.toLowerCase();
                if (title.includes(keyword)) {
                    item.style.display = ""; // tampilkan
                } else {
                    item.style.display = "none"; // sembunyikan
                }
            });
        });
    });

    document.getElementById('button-plus').addEventListener("click", function () {
        $('#stok_notif').html('');
        let jml = parseInt(document.getElementById('jumlah').value);
        jml += 1;
        $('#jumlah').val(jml);
        // let stok = document.getElementById('stok').value;
        /*
        if (jml > stok) {
            $('#stok_notif').append('Tidak boleh melebihi stok');
            $('#jumlah').val(stok);
        } else {
            $('#jumlah').val(jml);
        }*/
    });

    document.getElementById('button-minus').addEventListener("click", function () {
        $('#stok_notif').html('');
        let jml = parseInt(document.getElementById('jumlah').value);
        jml -= 1;
        if (jml == 0) {
            $('#stok_notif').append('Tidak bisa kurang dari 1');
            $('#jumlah').val('1');
        } else {
            $('#jumlah').val(jml);
        }
    });

</script>