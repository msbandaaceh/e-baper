var result = config.result;
var pesan = config.pesan;

$(function () {
    $(document).off('submit', '#formTambahBarang').on('submit', '#formTambahBarang', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_barang',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-barang').modal('hide');
                    loadDaftarBarang();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formAmbilBarang').on('submit', '#formAmbilBarang', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_ambil_barang',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#ambil-barang').modal('hide');
                    loadTabelAmbilBarang();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formTambahKeranjang').on('submit', '#formTambahKeranjang', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'tambah_keranjang',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#tambah-keranjang').modal('hide');
                    loadNotifKeranjang();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).off('submit', '#formUpdateStokBarang').on('submit', '#formUpdateStokBarang', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_update',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                if (res.success == '1') {
                    $('#update-stok').modal('hide');
                    loadDaftarBarang();
                }
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).on('submit', '#formPeran', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_peran',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                ModalRole('-1');
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).on('submit', '#formKategori', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_kategori',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                ModalKategori('-1');
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });

    $(document).on('submit', '#formSatuan', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: 'simpan_satuan',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                notifikasi(res.message, res.success);
                ModalSatuan('-1');
            },
            error: function () {
                notifikasi('Terjadi kesalahan saat menyimpan data.', 4);
            }
        });
    });
});

function notifikasi(pesan, result) {
    let icon;
    if (result == '1') {
        result = 'success';
        icon = 'bx bx-check-circle';
    } else if (result == '2') {
        result = 'warning';
        icon = 'bx bx-error';
    } else if (result == '3') {
        result = 'error';
        icon = 'bx bx-x-circle';
    } else {
        result = 'info';
        icon = 'bx bx-info-circle';
    }

    Lobibox.notify(result, {
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        icon: icon,
        sound: false,
        msg: pesan
    });
}

function info(pesan) {
    Swal.fire({
        title: '<h4>Perhatian</h4>',
        html: pesan,
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function loadPage(page) {
    cekToken();
    $('#app').html('<div class="page-wrapper"><div class="page-content"><div class="text-center p-4">Memuat...</div></div></div>');
    $.get("halamanutama/page/" + page, function (data) {
        $('#app').html(data);
    }).fail(function () {
        $('#app').html('<div class="text-danger">Halaman tidak ditemukan.</div>');
    });
}

function cekToken() {
    $.ajax({
        url: 'cek_token',
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (!res.valid) {
                alert(res.message);
                window.location.href = res.url;
            }
        }
    });
}

function ModalRole(id) {
    $('#role-pegawai').modal('show');
    $('#btnBatal').hide();
    if (id != '-1') {
        $('#tabel-role').html('');
        $('#btnBatal').show();
    }

    $.post('show_role',
        { id: id },
        function (response) {
            try {
                const json = JSON.parse(response); // pastikan response valid JSON
                $('#pegawai_').html('');

                let html = `<select class="form-control select2" id="pegawai" name="pegawai" style="width:100%">`;
                json.pegawai.forEach(row => {
                    html += `<option value="${row.pegawai_id}" data-nama="${row.fullname}" data-jabatan="${row.jabatan}">${row.fullname}</option>`;
                });
                html += `</select>`;
                $('#pegawai_').append(html);

                $('#peran_').html('');
                let role = `<select class="form-control select2" id="peran" name="peran" style="width:100%">`;
                role += `<option value="operator">Operator Persediaan</option>`;
                role += `</select>`;
                $('#peran_').append(role);

                $('#overlay').hide();

                $('#pegawai').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#role-pegawai'),
                    width: '100%',
                    placeholder: "Pilih pegawai",
                    templateResult: formatPegawaiOption,
                    templateSelection: formatPegawaiSelection
                });

                $('#peran').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#role-pegawai'),
                    width: '100%',
                    placeholder: "Pilih Peran"
                });

                if (id != '-1') {
                    $('#id').val('');

                    $('#id').val(json.id);
                    $('#pegawai').val(json.editPegawai).trigger('change');
                    $('#peran').val(json.editPeran).trigger('change');

                    $('#pegawai').on('select2:opening select2:selecting', function (e) {
                        e.preventDefault(); // mencegah dropdown terbuka
                    });
                } else {
                    $('#tabel-role').html('');

                    let data = `
                    <div class="table-responsive">
                    <table id="tabelPeran" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead><tbody>`;
                    json.data_peran.forEach(row => {
                        if (`${row.peran}` == 'operator') {
                            var peran_ = 'Operator Persediaan';
                        }
                        data += `
                        <tr>
                            <td>${row.nama}</td>
                            <td>`;

                        if (`${row.hapus}` == '0') {
                            data += `<span class='badge bg-success'>${peran_}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" id="editPeran" onclick="ModalRole('${row.id}')" title="Edit Peran">
                                    <i class="bx bx-pencil me-0"></i>
								</button>

                                <button type="button" class="btn btn-outline-danger" id="hapusPeran" onclick="blokPeran('${row.id}')" title="Blok Pegawai">
                                    <i class="bx bx-block me-0"></i>
								</button>`;
                        } else {
                            data += `<span class='badge bg-secondary'>${peran_}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success" id="hapusPeran" onclick="aktifPeran('${row.id}')" title="Aktifkan Pegawai">
                                    <i class="bx bx-check me-0"></i>
								</button>`;
                        }
                        data += `
                            </td>
                        </tr>`;
                    });
                    data += `
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <span class='badge bg-success'>Aktif</span>
                        <span class='badge bg-secondary'>Non-aktif</span>
                    </div>
                    </div>`;
                    $('#tabel-role').append(data);
                    $("#tabelPeran").DataTable({
                        lengthChange: false
                    });
                }
            } catch (e) {
                console.error("Gagal parsing JSON:", e);
                $('#pegawai_').html('<div class="alert alert-danger">Gagal memuat data pegawai.</div>');
            }
        }
    );
}

function aktifPeran(id) {
    Swal.fire({
        title: "Yakin ingin mengaktifkan kembali peran pegawai",
        text: "Data peran ini akan diaktifkan perannya",
        icon: "warning", // ⬅️ gunakan 'icon' bukan 'type'
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, aktifkan",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Eksekusi penghapusan setelah konfirmasi
            $.post('aktif_peran', { id: id }, function (response) {
                Swal.fire("Berhasil", "Peran telah diaktifkan", "success");
                ModalRole('-1');
            }).fail(function () {
                Swal.fire("Gagal", "Terjadi kesalahan saat mengaktifkan data", "error");
            });
        }
    });
}

function blokPeran(id) {
    Swal.fire({
        title: "Yakin ingin menonaktifkan peran pegawai",
        text: "Data peran ini akan dinonaktifkan perannya",
        icon: "warning", // ⬅️ gunakan 'icon' bukan 'type'
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, nonaktifkan",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Eksekusi penghapusan setelah konfirmasi
            $.post('blok_peran', { id: id }, function (response) {
                Swal.fire("Berhasil", "Peran telah dinonaktifkan", "success");
                ModalRole('-1');
            }).fail(function () {
                Swal.fire("Gagal", "Terjadi kesalahan saat menghapus data", "error");
            });
        }
    });
}

function formatPegawaiOption(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return $(`
        <div style="line-height:1.2">
            <div style="font-weight:bold;">${nama}</div>
            <div style="font-size:12px;">${jabatan}</div>
        </div>
    `);
}

function formatPegawaiSelection(option) {
    if (!option.id) return option.text;

    const nama = $(option.element).data('nama');
    const jabatan = $(option.element).data('jabatan');

    return `${nama} > ${jabatan}`;
}

function ModalKategori(id) {
    $('#kategori-barang').modal('show');
    $('#btnKategoriBatal').hide();
    if (id != '-1') {
        $('#tabel-kategori').html('');
        $('#btnKategoriBatal').show();
    }

    $.post('show_kategori',
        { id: id },
        function (response) {
            try {
                const json = JSON.parse(response); // pastikan response valid JSON

                $('#nama_kategori').val('');
                $('#nama_kategori').val(json.nama_kategori);

                $('#overlay').hide();

                if (id != '-1') {
                    $('#id_kategori').val('');

                    $('#id_kategori').val(json.id);
                } else {
                    $('#tabel-kategori').html('');

                    let data = `
                    <div class="table-responsive">
                    <table id="tabelKategori" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead><tbody>`;
                    json.data_kategori.forEach(row => {
                        data += `
                        <tr>
                            <td>${row.nama_kategori}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" id="editKategori" onclick="ModalKategori('${row.id}')" title="Edit Kategori">
                                    <i class="bx bx-pencil me-0"></i>
								</button>

                                <button type="button" class="btn btn-outline-danger" id="hapusKategori" onclick="hapusKategori('${row.id}')" title="Hapus Kategori">
                                    <i class="bx bx-trash me-0"></i>
								</button>
                            </td>
                        </tr>`;
                    });
                    data += `
                        </tbody>
                        </table>
                    </div>
                    </div>`;
                    $('#tabel-kategori').append(data);
                    $("#tabelKategori").DataTable({
                        lengthChange: false
                    });
                }
            } catch (e) {
                console.error("Gagal parsing JSON:", e);
                $('#tabel-kategori').html('<div class="alert alert-danger">Gagal memuat data kategori.</div>');
            }
        }
    );
}

function ModalSatuan(id) {
    $('#satuan-barang').modal('show');
    $('#btnSatuanBatal').hide();
    if (id != '-1') {
        $('#tabel-satuan').html('');
        $('#btnSatuanBatal').show();
    }

    $.post('show_satuan',
        { id: id },
        function (response) {
            try {
                const json = JSON.parse(response); // pastikan response valid JSON
                $('#nama_satuan').val('');

                $('#nama_satuan').val(json.nama_satuan);

                $('#overlay').hide();

                if (id != '-1') {
                    $('#id_satuan').val('');

                    $('#id_satuan').val(json.id);
                } else {
                    $('#tabel-satuan').html('');

                    let data = `
                    <div class="table-responsive">
                    <table id="tabelSatuan" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead><tbody>`;
                    json.data_satuan.forEach(row => {
                        data += `
                        <tr>
                            <td>${row.nama_satuan}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" id="editSatuan" onclick="ModalSatuan('${row.id}')" title="Edit Satuan">
                                    <i class="bx bx-pencil me-0"></i>
								</button>

                                <button type="button" class="btn btn-outline-danger" id="hapusSatuan" onclick="hapusSatuan('${row.id}')" title="Hapus Satuan">
                                    <i class="bx bx-trash me-0"></i>
								</button>
                            </td>
                        </tr>`;
                    });
                    data += `
                        </tbody>
                        </table>
                    </div>
                    </div>`;
                    $('#tabel-satuan').append(data);
                    $("#tabelSatuan").DataTable({
                        lengthChange: false
                    });
                }
            } catch (e) {
                console.error("Gagal parsing JSON:", e);
                $('#tabel-satuan').html('<div class="alert alert-danger">Gagal memuat data satuan.</div>');
            }
        }
    );
}

function dataBarang(id) {
    $.post('show_barang', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $('#id').val('');
            $('#nama').val('');
            $('#kode').val('');
            $('#deskripsi').val('');
            document.getElementById('preview').removeAttribute('src');
            $('#kategori_').html('');
            $('#satuan_').html('');
            $('#stok').val('');

            $('#id').val(json.id);
            $('#kategori_').append(json.kategori);
            $('#satuan_').append(json.satuan);

            $('#kategori, #satuan').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#tambah-barang .modal-content'),
                width: '100%',
                dropdownAutoWidth: true
            })

            if (json.id != '-1') {
                $('#nama').val(json.nama);
                $('#kode').val(json.kode);
                $('#deskripsi').val(json.deskripsi);
                document.getElementById('preview').setAttribute('src', json.foto);
                $('#stok').val(json.stok);
            }
        }
    });
}

function hapusBarang(id) {
    Swal.fire({
        title: "<h5>HAPUS BARANG</h5>",
        html: "<h5>Apa Anda Yakin Akan Menghapus Barang Ini</h5>",
        icon: "warning",
        background: '#1e1e1e',
        showCancelButton: true,
        confirmButtonColor: "#DD2A2A",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('hapus_barang', { id: id }, function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Anda Sudah Menghapus Barang",
                        icon: "success",
                        confirmButtonColor: "#8EC165",
                        confirmButtonText: "Oke"
                    }).then(() => {
                        loadDaftarBarang();
                    });
                } else {
                    Swal.fire("Gagal", "Anda Gagal Menghapus Barang, Silakan Ulangi Lagi", "error");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Batal", "Anda Batal Menghapus Barang", "info");
        }
    });
}

function loadDaftarBarangDashboard() {
    $.post('show_daftar_barang', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#daftarBarang').html(''); // kosongkan wrapper

            if (!json.data_barang || json.data_barang.length === 0) {
                // Kalau kosong
                $('#daftarBarang').html(`
                    <div class="row">
                        <div class="col">
                            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-info">Informasi</h6>
                                        <div>Belum Ada Barang yang Diinput. Terima kasih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="row row-cols-2 row-cols-sm-4 row-cols-lg-6 row-cols-xl-8 row-cols-xxl-8 product-grid" id="daftar-barang">
            `;

            json.data_barang.forEach((row, index) => {
                // Daftar Barang
                data += `
                    <div class="col item-barang">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#tambah-keranjang" onclick="orderBarang('${row.id}')">
                            <img src="${row.foto}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title cursor-pointer">${row.nama_barang}</h6>
                                <div class="clearfix">
                                <!-- <p class="mb-0 float-start">Stok : <strong>${row.stok_dashboard} ${row.nama_satuan}</strong></p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#daftarBarang').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#daftarBarang').html('<div class="alert alert-danger">Gagal memuat data barang.</div>');
        }
    });
}

function daftarBarangDashboardKategori(id) {
    $.post('show_daftar_barang_kategori', { id: id }, function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#daftarBarang').html(''); // kosongkan wrapper

            if (!json.data_barang || json.data_barang.length === 0) {
                // Kalau kosong
                $('#daftarBarang').html(`
                    <div class="row">
                        <div class="col">
                            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-info">Informasi</h6>
                                        <div>Belum Ada Barang yang Diinput. Terima kasih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="row row-cols-2 row-cols-sm-6 row-cols-lg-6 row-cols-xl-8 row-cols-xxl-8 product-grid" id="daftar-barang">
            `;

            json.data_barang.forEach((row, index) => {
                // Daftar Barang
                data += `
                    <div class="col item-barang">
                        <div class="card">
                            <img src="${row.foto}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title cursor-pointer">${row.nama_barang}</h6>
                                <div class="clearfix">
                                <!-- <p class="mb-0 float-start">Stok : <strong>${row.stok_dashboard} ${row.nama_satuan}</strong></p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#daftarBarang').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#daftarBarang').html('<div class="alert alert-danger">Gagal memuat data barang.</div>');
        }
    });
}

function loadDaftarBarang() {
    $.post('show_daftar_barang', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#daftarBarang').html(''); // kosongkan wrapper

            if (!json.data_barang || json.data_barang.length === 0) {
                // Kalau kosong
                $('#daftarBarang').html(`
                    <div class="row">
                        <div class="col">
                            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-info">Informasi</h6>
                                        <div>Belum Ada Barang yang Diinput. Terima kasih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4 product-grid" id="daftar-barang">
            `;

            json.data_barang.forEach((row, index) => {
                // Daftar Barang
                data += `
                    <div class="col item-barang">
                        <div class="card">
                            <img src="${row.foto}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title cursor-pointer">${row.nama_barang}</h6>
                                <div class="clearfix">
                                    <p class="mb-0 float-start">Stok : <strong>${row.stok} ${row.nama_satuan}</strong></p>
                                </div>
                                <!-- <p class="mb-0 float-start">Dipesan : <strong>${row.stok_reserved} ${row.nama_satuan}</strong></p> -->
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#tambah-barang" onclick="dataBarang('${row.id}')">Edit</button>
                                <button type="button" class="btn btn-success" onclick="updateBarang('${row.id}')" data-bs-toggle="modal"
                                    data-bs-target="#update-stok">Update Stok</button>
                                <button type="button" class="btn btn-danger" onclick="hapusBarang('${row.id}')">Hapus</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#daftarBarang').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#daftarBarang').html('<div class="alert alert-danger">Gagal memuat data barang.</div>');
        }
    });
}

function daftarBarangKategori(id) {
    $.post('show_daftar_barang_kategori', { id: id }, function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#daftarBarang').html(''); // kosongkan wrapper

            if (!json.data_barang || json.data_barang.length === 0) {
                // Kalau kosong
                $('#daftarBarang').html(`
                    <div class="row">
                        <div class="col">
                            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-info">Informasi</h6>
                                        <div>Belum Ada Barang yang Diinput. Terima kasih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4 product-grid" id="daftar-barang">
            `;

            json.data_barang.forEach((row, index) => {
                // Daftar Barang
                data += `
                    <div class="col item-barang">
                        <div class="card">
                            <img src="${row.foto}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title cursor-pointer">${row.nama_barang}</h6>
                                <div class="clearfix">
                                    <p class="mb-0 float-start">Stok : <strong>${row.stok} ${row.nama_satuan}</strong></p>
                                </div>
                                <!-- <p class="mb-0 float-start">Dipesan : <strong>${row.stok_reserved} ${row.nama_satuan}</strong></p> -->
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#tambah-barang" onclick="dataBarang('${row.id}')">Edit</button>
                                <button type="button" class="btn btn-success" onclick="updateBarang('${row.id}')" data-bs-toggle="modal"
                                    data-bs-target="#update-stok">Update Stok</button>
                                <button type="button" class="btn btn-danger" onclick="hapusBarang('${row.id}')">Hapus</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#daftarBarang').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#daftarBarang').html('<div class="alert alert-danger">Gagal memuat data barang.</div>');
        }
    });
}

function loadNotifKeranjang() {
    $.post('show_daftar_keranjang', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid
            $('#countKeranjang').html('');
            $('#keranjang-ikon').html(''); // kosongkan wrapper

            if (!json.data_keranjang || json.data_keranjang.length === 0) {
                // Kalau kosong
                $('#keranjang-ikon').html(`
                    <p class="text-center p-4">Keranjang Kosong</p>
                `);
                return;
            }

            $('#countKeranjang').append('<span class="alert-count">' + json.data_keranjang.length + '</span>');

            let data = ``;

            // Kalau ada data, buat tabelnya
            json.data_keranjang.forEach((row, index) => {
                data += `
                <a class="dropdown-item" href="javascript:;">
                    <div class="d-flex align-items-center">
                        <div class="user">
                            <img src="${row.foto}" class="msg-avatar" alt="${row.nama_barang}">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="msg-name">${row.nama_barang}<span class="msg-time float-end">${row.jumlah}</span></h6>
                        </div>
                    </div>
                </a>
            `;
            });

            $('#keranjang-ikon').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#keranjang-ikon').html('<div class="alert alert-danger">Gagal memuat data keranjang.</div>');
        }
    });
}

function loadDaftarKeranjang() {
    $.post('show_daftar_keranjang', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#daftarKeranjang').html(''); // kosongkan wrapper

            if (!json.data_keranjang || json.data_keranjang.length === 0) {
                // Kalau kosong
                $('#daftarKeranjang').html(`
                    <div class="row">
                        <div class="col">
                            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-info">Informasi</h6>
                                        <div>Belum Ada Barang Dikeranjang. Terima kasih.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat daftarnya
            let data = `
                <div class="table-responsive">
                <table id="daftarKeranjangData" class="table">
                    <tbody>
            `;

            json.data_keranjang.forEach((row, index) => {
                // Tombol aksi
                let tombolAksi = `
                    <button type="button" class="btn btn-danger" title="Hapus Data"
                            onclick="hapusKeranjang('${row.id_jumlah}')">
                            <i class="bx bxs-trash"></i>
                    </button>
                `;

                let tombolJumlah = `
                    <button class="btn btn-light" type="button" onclick="kurangJumlah('${row.id_jumlah}')"> - </button>
					<input type="text" class="form-control" name="jumlah" id="input${row.id_jumlah}" value="${row.jumlah}">
					<button class="btn btn-light" type="button" onclick="tambahJumlah('${row.id_jumlah}')"> + </button>
                `;

                // Baris tabel
                data += `
                    <tr>
                        <td class="text-center g-0"><img src="${row.foto}" class="p-1 border" width="90" height="90" alt="${row.nama_barang}"></td>
                        <td>
                            <div class="flex-grow-1 ms-3">
								<h5 class="mt-0">${row.nama_barang}</h5>
								<div class="col">
								    <label class="form-label">Jumlah</label>
                                    <input type="hidden" id="stok${row.id_jumlah}" value="${row.stok}">
								    <div class="input-group input-spinner">
									    ${tombolJumlah}
								    </div>
                                    <div class="text-danger mt-1" id="stok_notif${row.id_jumlah}">
							    </div>
							</div>
                        </td>
                        <td class="text-center p-4">${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                </table>
                </div>
            `;

            $('#daftarKeranjang').append(data);

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#daftarKeranjang').html('<div class="alert alert-danger">Gagal memuat data keranjang.</div>');
        }
    });
}

function orderBarang(id) {
    $.post('show_barang', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $('#id').val('');
            $('#nama_barang').html('');
            $('#deskripsi').html('');
            $('#stok_label').html('');
            $('#stok').val('');
            document.getElementById('preview').removeAttribute('src');

            $('#id').val(json.id);

            if (json.id != '-1') {
                $('#jumlah').val('1');
                $('#nama_barang').append(json.nama);
                $('#deskripsi').append(json.deskripsi);
                $('#stok_label').append('Stok : ' + json.stok + ' ' + json.nama_satuan);
                document.getElementById('preview').setAttribute('src', json.foto);
                $('#stok').val(json.stok);
            }
        }
    });
}

function kurangJumlah(id) {
    let input = document.getElementById('input' + id);
    let notif = $('#stok_notif' + id);

    notif.html(''); // kosongkan notif

    let jml = parseInt(input.value) || 1;
    jml -= 1;

    if (jml < 1) {
        hapusKeranjang(id);
        input.value = 1;
    } else {
        input.value = jml;
        $.post('update_jumlah_barang_keranjang', {
            id: id, jumlah: jml
        });
    }
}

function tambahJumlah(id) {
    let inputEl = document.getElementById('input' + id);
    let notif = $('#stok_notif' + id);
    let stok = parseInt(document.getElementById('stok' + id).value);

    notif.html('');

    let jml = parseInt(inputEl.value) || 1;
    jml += 1;

    inputEl.value = jml;
    $.post('update_jumlah_barang_keranjang', {
        id: id, jumlah: jml
    });
    /*
    if (jml > stok) {
        notif.html('<span class="badge rounded-pill bg-danger">Tidak boleh melebihi stok</span>');
        inputEl.value = stok;
    } else {
        inputEl.value = jml;
        $.post('update_jumlah_barang_keranjang', {
            id: id, jumlah: jml
        });
    }
    */
}

function hapusKeranjang(id) {
    Swal.fire({
        title: "<h5>HAPUS BARANG DI KERANJANG</h5>",
        html: "<h5>Apa Anda Yakin Akan Menghapus Barang di Keranjang?</h5>",
        icon: "warning",
        background: '#1e1e1e',
        showCancelButton: true,
        confirmButtonColor: "#DD2A2A",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Hapus !",
        cancelButtonText: "Tidak !"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('hapus_keranjang', { id: id }, function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    Swal.fire({
                        title: "Berhasil !",
                        text: "Anda Sudah Menghapus Barang",
                        icon: "success",
                        confirmButtonColor: "#8EC165",
                        confirmButtonText: "Oke"
                    }).then(() => {
                        loadNotifKeranjang();
                        loadDaftarKeranjang();
                    });
                } else {
                    Swal.fire("Gagal", "Anda Gagal Menghapus Barang, Silakan Ulangi Lagi", "error");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Batal", "Anda Batal Menghapus Barang", "info");
        }
    });
}

function checkout() {
    let keranjang = [];

    document.querySelectorAll("input[name='jumlah']").forEach(input => {
        let id_jumlah = input.id.replace("input", "");
        let jumlah = input.value;

        keranjang.push({
            id: id_jumlah,
            jumlah: jumlah
        });
    });

    if (keranjang.length === 0) {
        info("Keranjang kosong!");
        return;
    }

    Swal.fire({
        title: "<h5>KIRIM PERMOHONAN BARANG</h5>",
        html: "<h5>Anda Yakin Akan Mengirimkan Permohonan ?</h5>",
        icon: "question",
        background: '#1e1e1e',
        showCancelButton: true,
        confirmButtonColor: "#3396D3",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Kirim",
        cancelButtonText: "Tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "checkout", // controller CI3
                type: "POST",
                data: { keranjang: keranjang },
                success: function (response) {
                    try {
                        let json = JSON.parse(response);
                        if (json.success == "1") {
                            notifikasi("Checkout berhasil! Permohonan Berhasil Kirim", 1);
                            loadNotifKeranjang();
                            loadDaftarKeranjang();
                        } else {
                            notifikasi("Checkout gagal: " + json.message, 3);
                        }
                    } catch (e) {
                        notifikasi("Response tidak valid", 4);
                    }
                }
            });
        }
    });
}

function loadNotifValidasi() {
    $.post('show_tabel_validasi', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid
            $('#countValidasi').html('');

            if (!json.data_validasi || json.data_validasi.length === 0) {
                $('#countValidasi').html('');
            } else {
                $('#countValidasi').append('<span class="alert-count">' + json.data_validasi.length + '</span>');
            }
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
        }
    });
}

function loadTabelValidasi() {
    $.post('show_tabel_validasi', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelValidasi').html(''); // kosongkan wrapper

            if (!json.data_validasi || json.data_validasi.length === 0) {
                // Kalau kosong
                $('#tabelValidasi').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Izin Yang Dibuat. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelValidasiData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_validasi.forEach((row, index) => {

                // Tombol aksi
                tombolAksi = `
                        <button type="button" class="btn btn-warning" data-bs-target="#validasi-modal"
                            onclick="BukaValidasiPermohonan('${row.id}')" data-bs-toggle="modal" title="Validasi">
                            <i class="bx bxs-pencil"></i>
                        </button>
                    `;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama_pegawai}
                        </td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelValidasi').append(data);

            // Aktifkan DataTables
            $("#tabelValidasiData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelValidasi').html('<div class="alert alert-danger">Gagal memuat data validasi.</div>');
        }
    });
}

function BukaValidasiPermohonan(id) {
    $.post('show_detail_permohonan', { id: id }, function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelDetailPermohonan').html(''); // kosongkan wrapper
            $('#judul').html('');
            $('#judul').html(json.judul);

            // Kalau ada data, buat daftarnya
            let data = `
                <div class="table-responsive">
                <input type="hidden" class="form-control" id="permohonan_id" value="${json.permohonan_id}">
                <table id="tabelDetailPermohonanData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BARANG</th>
                            <th>JUMLAH DIMINTA</th>
                            <th>STOK BARANG</th>
                            <th>JUMLAH DIBERIKAN</th>
                            <th>AKSI</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_keranjang.forEach((row, index) => {
                // Tombol aksi
                let tombolAksi = `
                    <select class="form-control" id="status${row.detail_id}" name="status">
                        <option value="1">Setuju</option>
                        <option value="2">Tidak Setuju</option>
                    </select>
                `;

                let tombolJumlah = `
					<input type="text" class="form-control" autocomplete="off" name="jumlah" id="input${row.detail_id}">
                `;

                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.nama_barang}</a></td>
                        <td>${row.jumlah}
                            <input type="hidden" value="${row.jumlah}" class="form-control" autocomplete="off" name="jumlah_minta" id="input${row.detail_id}">
                        </td>
                        <td>${row.stok}</td>
                        <td>
                            ${tombolJumlah}
                        </td>
                        <td>
                            ${tombolAksi}
                        </td>
                        <td><input type="text" class="form-control" autocomplete="off" name="ket" id="ket${row.detail_id}"></td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                </table>
                </div>
            `;

            $('#tabelDetailPermohonan').append(data);

            $("#tabelDetailPermohonanData").DataTable();

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelDetailPermohonan').html('<div class="alert alert-danger">Gagal memuat data detail permohonan.</div>');
        }
    });
}

function simpanValidasi() {
    let permohonan_id = document.getElementById('permohonan_id').value;

    let detail = [];

    document.querySelectorAll("#tabelDetailPermohonanData tbody tr").forEach(tr => {
        let inputMinta = tr.querySelector("input[name='jumlah_minta']");
        let inputJumlah = tr.querySelector("input[name='jumlah']");
        let selectStatus = tr.querySelector("select[name='status']");
        let inputKet = tr.querySelector("input[name='ket']");

        if (!inputJumlah || !selectStatus || !inputKet) return;

        let id = inputJumlah.id.replace("input", "");
        let jum_minta = inputMinta.value;
        let jumlah = inputJumlah.value;
        let status = selectStatus.value;
        let ket = inputKet.value;

        detail.push({
            detail_id: id,
            jum_minta: jum_minta,
            jumlah_diberikan: jumlah,
            status: status,
            keterangan: ket
        });
    });

    Swal.fire({
        title: "<h5>VALIDASI PERMOHONAN</h5>",
        html: "<h5>Apakah Anda yakin akan menyimpan hasil validasi ini?</h5>",
        icon: "question",
        background: '#1e1e1e',
        showCancelButton: true,
        confirmButtonColor: "#3396D3",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "simpan_validasi", // Controller CI3
                type: "POST",
                data: { permohonan_id: permohonan_id, detail: detail },
                success: function (response) {
                    try {
                        let json = JSON.parse(response);
                        if (json.success == "1") {
                            notifikasi("Validasi berhasil disimpan!", 1);
                            $('#validasi-modal').modal('hide');
                            // misalnya redirect ke daftar permohonan
                            loadTabelValidasi();
                            loadNotifValidasi();
                        } else {
                            notifikasi("Validasi gagal: " + json.message, 3);
                        }
                    } catch (e) {
                        notifikasi("Response tidak valid", 4);
                    }
                }
            });
        }
    });

}

function loadNotifValid() {
    $.post('show_permohonan_valid', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid
            $('#countValid').html('');

            if (!json.data_validasi || json.data_validasi.length === 0) {
                $('#countValid').html('');
            } else {
                $('#countValid').append('<span class="alert-count">' + json.data_validasi.length + '</span>');
            }
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
        }
    });
}

function loadTabelValid() {
    $.post('show_tabel_validasi', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelValid').html(''); // kosongkan wrapper

            if (!json.data_validasi || json.data_validasi.length === 0) {
                // Kalau kosong
                $('#tabelValid').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Pemohonan Izin Yang Dibuat. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelValidData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_validasi.forEach((row, index) => {

                // Tombol aksi
                tombolAksi = `
                        <button type="button" class="btn btn-warning" data-bs-target="#valid-modal"
                            onclick="BukaValidPermohonan('${row.id}')" data-bs-toggle="modal" title="Validasi">
                            <i class="bx bxs-pencil"></i>
                        </button>
                    `;

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${row.nama_pegawai}
                        </td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelValid').append(data);

            // Aktifkan DataTables
            $("#tabelValidData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelValidasi').html('<div class="alert alert-danger">Gagal memuat data validasi.</div>');
        }
    });
}

function BukaValidPermohonan(id) {
    $.post('show_detail_permohonan_valid', { id: id }, function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelDetailPermohonanValid').html(''); // kosongkan wrapper
            $('#judul').html('');
            $('#judul').html(json.judul);

            // Kalau ada data, buat daftarnya
            let data = `
                <div class="table-responsive">
                <input type="hidden" class="form-control" id="permohonan_id" value="${json.permohonan_id}">
                <table id="tabelDetailPermohonanValidData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BARANG</th>
                            <th>JUMLAH DIMINTA</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_valid.forEach((row, index) => {
                // Tombol aksi

                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.nama_barang}</a></td>
                        <td>${row.jumlah}
                            <input type="hidden" value="${row.jumlah}" class="form-control" autocomplete="off" name="jumlah_minta" id="input${row.detail_id}">
                        </td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                </table>
                </div>
            `;

            $('#tabelDetailPermohonanValid').append(data);

            $("#tabelDetailPermohonanValidData").DataTable();

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelDetailPermohonanValid').html('<div class="alert alert-danger">Gagal memuat data detail permohonan.</div>');
        }
    });
}

function simpanValid() {
    let permohonan_id = document.getElementById('permohonan_id').value;

    let detail = [];

    document.querySelectorAll("#tabelDetailPermohonanValidData tbody tr").forEach(tr => {
        let inputMinta = tr.querySelector("input[name='jumlah_minta']");

        let id = inputMinta.id.replace("input", "");
        let jum_minta = inputMinta.value;

        detail.push({
            detail_id: id,
            jum_minta: jum_minta,
        });
    });

    Swal.fire({
        title: "<h5>KONFIRMASI PENYERAHAN BARANG</h5>",
        html: "<h5>Apakah Anda Yakin Sudah Mengantarkan Barang?</h5>",
        icon: "question",
        background: '#1e1e1e',
        showCancelButton: true,
        confirmButtonColor: "#3396D3",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Sudah",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "simpan_konfirmasi", // Controller CI3
                type: "POST",
                data: { permohonan_id: permohonan_id, detail: detail },
                success: function (response) {
                    try {
                        let json = JSON.parse(response);
                        if (json.success == "1") {
                            notifikasi("Konfirmasi Berhasil! Barang sudah diantar ke Pemohon", 1);
                            $('#valid-modal').modal('hide');
                            // misalnya redirect ke daftar permohonan
                            loadTabelValid();
                            loadNotifValid();
                        } else {
                            notifikasi("Konfirmasi gagal: " + json.message, 3);
                        }
                    } catch (e) {
                        notifikasi("Response tidak valid", 4);
                    }
                }
            });
        }
    });

}

function updateBarang(id) {
    $.post('show_barang', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $('#id_barang').val('');
            $('#v_nama').val('');
            $('#v_kode').val('');

            $('#id_barang').val(json.id);
            $('#v_nama').val(json.nama);
            $('#v_kode').val(json.kode);

        }
    });
}

function loadTabelRiwayatPermohonan() {
    $.post('show_tabel_riwayat_permohonan', function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelRiwayatPermohonan').html(''); // kosongkan wrapper

            if (!json.data_riwayat || json.data_riwayat.length === 0) {
                // Kalau kosong
                $('#tabelRiwayatPermohonan').html(`
                    <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class='bx bx-info-square'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Informasi</h6>
                                <div>Belum Ada Permohonan Barang Persediaan Yang Dibuat. Terima kasih.</div>
                            </div>
                        </div>
                    </div>
                `);
                return;
            }

            // Kalau ada data, buat tabelnya
            let data = `
                <div class="table-responsive">
                <table id="tabelRiwayatPermohonanData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th class="text-center">STATUS PERMOHONAN</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_riwayat.forEach((row, index) => {
                // Tombol aksi
                let tombolAksi = `
                        <button type="button" class="btn btn-info" title="Lihat Detail Permohonan"
                            data-bs-target="#detail-riwayat"
                            onclick="detailRiwayatPermohonan('${row.id}')"
                            data-bs-toggle="modal"><i class="bx bxs-show"></i>
                        </button>
                `;

                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-primary radius-30">Menunggu Diproses</span>';
                } else if (row.status == '1') {
                    statusBadge = '<span class="btn btn-warning radius-30">Sudah Validasi tk Kasub</span>';
                } else if (row.status == '2') {
                    statusBadge = '<span class="btn btn-warning radius-30">Sudah Validasi tk Sekretaris</span>';
                } else if (row.status == '3') {
                    statusBadge = '<span class="btn btn-success radius-30">Selesai</span>';
                }

                // Baris tabel
                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.tgl}</td>
                        <td class="text-center">${statusBadge}</td>
                        <td class="text-center">${tombolAksi}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th class="text-center">STATUS PERMOHONAN</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            `;

            $('#tabelRiwayatPermohonan').append(data);

            // Aktifkan DataTables
            $("#tabelRiwayatPermohonanData").DataTable();
        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelRiwayatPermohonan').html('<div class="alert alert-danger">Gagal memuat data riwayat.</div>');
        }
    });
}

function detailRiwayatPermohonan(id) {
    $.post('show_detail_riwayat_permohonan', { id: id }, function (response) {
        try {
            const json = JSON.parse(response); // Pastikan server kirim JSON valid

            $('#tabelDetailRiwayatBarang').html(''); // kosongkan wrapper
            $('#riwayatPermohonan').html('');

            let dataRiwayat = `
                <div class="row g-0">
					<div class="col-sm py-2">
						<div class="card border-primary shadow radius-15">
							<div class="card-body">
								<div class="float-end text-white small">${json.tanggal_permohonan}</div>
								<p class="card-text">Tanggal Permohonan Dibuat</p>
							</div>
						</div>
					</div>
					<div class="col-sm-1 text-center flex-column d-none d-sm-flex">
						<div class="row h-50">
							<div class="col border-end">&nbsp;</div>
							<div class="col">&nbsp;</div>
						</div>
						<h5 class="m-2">
						<span class="badge rounded-pill bg-white">&nbsp;</span>
					</h5>
						<div class="row h-50">
							<div class="col border-end">&nbsp;</div>
							<div class="col">&nbsp;</div>
						</div>
					</div>
					<div class="col-sm">
						<!--spacer-->
					</div>
				</div>
            `;

            json.data_riwayat.forEach((row, index) => {
                let isKiri = row.posisi === 'kiri';

                dataRiwayat += `
                    <div class="row g-0">
                        ${isKiri ? `
                        <div class="col-sm py-2">
                            <div class="card border-primary shadow radius-15">
                            <div class="card-body">
                                <div class="float-end text-white small">${row.tanggal}</div>
                                <p class="card-text">Diproses oleh ${row.level}</p>
                            </div>
                            </div>
                        </div>
                        ` : `<div class="col-sm"> <!-- spacer --> </div>`}

                        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col ${isKiri ? 'border-end' : ''}">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                        <span class="badge rounded-pill bg-white">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col ${isKiri ? 'border-end' : ''}">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        </div>

                        ${!isKiri ? `
                        <div class="col-sm py-2">
                            <div class="card border-primary shadow radius-15">
                            <div class="card-body">
                                <div class="float-end text-white small">${row.tanggal}</div>
                                <p class="card-text">Diproses oleh ${row.level}</p>
                            </div>
                            </div>
                        </div>
                        ` : `<div class="col-sm"> <!-- spacer --> </div>`}
                    </div>
                `;
            });

            // Kalau ada data, buat daftarnya
            let data = `
                <div class="table-responsive">
                <table id="tabelDetailRiwayatBarangData" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BARANG</th>
                            <th>JUMLAH DIMINTA</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            json.data_barang.forEach((row, index) => {
                // Tombol aksi

                let statusBadge = '';
                if (row.status == '0') {
                    statusBadge = '<span class="btn btn-primary radius-30">Menunggu Diproses</span>';
                } else if (row.status == '1') {
                    statusBadge = '<span class="btn btn-success radius-30">Setuju</span>';
                } else if (row.status == '2') {
                    statusBadge = '<span class="btn btn-danger radius-30">Tidak Setuju</span>';
                }

                data += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.nama_barang}</a></td>
                        <td>${row.jumlah}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
            });

            data += `
                    </tbody>
                </table>
                </div>
            `;

            $('#riwayatPermohonan').append(dataRiwayat);
            $('#tabelDetailRiwayatBarang').append(data);

            $("#tabelDetailRiwayatBarangData").DataTable();

        } catch (e) {
            console.error("Gagal parsing JSON:", e);
            $('#tabelDetailRiwayatBarang').html('<div class="alert alert-danger">Gagal memuat data detail permohonan.</div>');
        }
    });
}

function ambilBarang(id) {
    $.post('show_barang_lemari', {
        id: id
    }, function (response) {
        var json = jQuery.parseJSON(response);
        if (json.st == 1) {
            $('#id').val('');
            $('#barang_').html('');
            $('#jumlah').val('');

            $('#id').val(json.id);
            $('#barang_').append(json.barang);
            $('#jumlah').val(json.jumlah);

            $('#barang').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#ambil-barang .modal-content'),
                width: '100%',
                dropdownAutoWidth: true
            })
        }
    });
}