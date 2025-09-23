<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Permohonan Barang</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <h6 class="mb-0 text-uppercase">DAFTAR PERMOHONAN BARANG VALID</h6>
        <hr />

        <div class="row row-cols-12">
            <div class="col">
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-body">
                        <div class="card-body" id="tabelValid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="valid-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-cart me-1 font-22"></i>
                </div>
                <h5 class="mb-0" id="judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body" id="tabelDetailPermohonanValid"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-end">
                    <button id="submit" type="submit" class="btn btn-light" onclick="simpanValid()">Simpan Validasi</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        loadTabelValid();
    });
</script>