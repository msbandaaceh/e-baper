<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Data Barang</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">DAFTAR BARANG PERSEDIAAN</h6>
        <hr />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-xl-2">
                                <button class="btn btn-light mb-3 mb-lg-0" data-bs-toggle="modal"
                                    data-bs-target="#tambah-barang"
                                    onclick="dataBarang('<?= base64_encode($this->encryption->encrypt(-1)); ?>')"><i
                                        class="bx bxs-plus-square"></i>Tambah</button>
                            </div>
                            <div class="col-lg-6 col-xl-10">
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
                                                                    onclick="daftarBarangKategori('<?= $item->id ?>')"><?= $item->nama_kategori ?></a>
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

<div class="modal fade" id="tambah-barang" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formTambahBarang" class="modal-content bg-success" enctype="multipart/form-data">
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
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <div class="border border-3 p-4 rounded">
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Barang <code> *</code></label>
                                <input type="text" class="form-control ltr-input" id="kode" name="kode"
                                    placeholder="Masukkan Kode Barang" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang <code> *</code></label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan Nama Barang" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi <code> *</code></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                    placeholder="Masukkan Deskripsi Barang" autocomplete="off"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Produk</label>
                                <img class="mb-3" id="preview" src="" style="max-width: 200px; margin-top:10px;" />
                                <input class="form-control" id="gambar" type="file" accept="image/png" name="gambar">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="border border-3 p-4 rounded">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="stok" class="form-label">Stok Barang <code>*</code></label>
                                    <input type="text" class="form-control" id="stok" name="stok" autocomplete="off"
                                        placeholder="1">
                                </div>
                                <div class="col-12">
                                    <label for="satuan" class="form-label">Satuan <code>*</code></label>
                                    <div id="satuan_"></div>
                                </div>
                                <div class="col-12">
                                    <label for="kategori" class="form-label">Kategori Barang <code> *</code></label>
                                    <div id="kategori_"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-label text-danger">* Wajib Diisi</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-light" id="btn-simpan">Simpan</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="update-stok" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-success">
            <form method="POST" id="formUpdateStokBarang">
                <div class="modal-header">
                    <div>
                        <i class="bx bxs-user me-1 font-22"></i>
                    </div>
                    <h5 class="mb-0">UPDATE STOK BARANG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" class="form-control" id="id_barang" name="id">
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="v_kode" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="v_kode" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="v_nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="v_nama" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="update_stok" class="form-label">Pembaharuan Stok Barang <code>*</code></label>
                            <input type="text" class="form-control" id="update_stok" name="stok" autocomplete="off"
                                placeholder="Masukkan Jumlah Barang Diinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-label text-danger">* Wajib Diisi</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-light" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<script>
    document.getElementById('gambar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('preview').setAttribute('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $(document).ready(function () {
        loadDaftarBarang();

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
</script>