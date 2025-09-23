<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">E-BAPER</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;" data-page="dashboard"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">KERANJANG</h6>
        <hr />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" id="daftarKeranjang">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-light" onclick="checkout()">Kirim Permohonan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        loadDaftarKeranjang();
    });
</script>