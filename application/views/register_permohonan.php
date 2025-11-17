<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ANANDA</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Register Permohonan Barang</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">REGISTER PERMOHONAN BARANG</h6>
        <hr />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" id="tabelRegisterPermohonan"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail-register" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <div>
                    <i class="bx bxs-file me-1 font-22"></i>
                </div>
                <h5 class="mb-0" id="judul-register">DETAIL PERMOHONAN BARANG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body" id="infoRegisterPermohonan"></div>
                </div>
                <div class="card">
                    <div class="card-body" id="tabelDetailRegisterBarang"></div>
                </div>
                <div class="card">
                    <div class="card-body" id="riwayatRegisterApproval"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light text-white" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        loadTabelRegisterPermohonan();
    });
</script>

