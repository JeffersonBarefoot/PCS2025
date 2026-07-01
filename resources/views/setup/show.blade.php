<!doctype html>
<html lang="en">

@include('Common.001head')

<body>
<div class="container-fluid">

    <div class="row">
        @include('Common.102appnavbar')
    </div>

    <div class="row">
        <div class="col-10 offset-1 py-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 mb-3 js-flash" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 mb-3 js-flash" role="alert">
                    <strong>Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show py-2 mb-3 js-flash" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <h4 class="fw-bold mb-4">Setup &amp; Data Import</h4>

            {{-- ── Import Data ──────────────────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold">Import Data</div>
                <div class="card-body">
                    <p class="text-muted small mb-4">
                        Upload CSV files to populate your data.
                        Duplicate records (matched by company + position number for positions, or employee number for incumbents) are skipped automatically.
                    </p>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="fw-semibold mb-1">Positions</h6>
                                <p class="text-muted small mb-3">
                                    Imports position records. Requires columns matching the positions table headers.
                                </p>
                                <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="importFileName1" accept=".csv" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-primary text-nowrap">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="fw-semibold mb-1">Position History</h6>
                                <p class="text-muted small mb-3">
                                    Imports historical position snapshots into hpositions.
                                </p>
                                <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="importFileName2" accept=".csv" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-primary text-nowrap">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="fw-semibold mb-1">Incumbents</h6>
                                <p class="text-muted small mb-3">
                                    Imports incumbent records. Requires columns matching the incumbents table headers.
                                </p>
                                <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="importFileName3" accept=".csv" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-primary text-nowrap">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="fw-semibold mb-1">Incumbent History</h6>
                                <p class="text-muted small mb-3">
                                    Imports historical incumbent snapshots into hincumbents.
                                </p>
                                <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="importFileName4" accept=".csv" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-primary text-nowrap">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Incumbent Changes ────────────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold">Incumbent Changes</div>
                <div class="card-body">
                    <div class="border rounded p-3" style="max-width:520px">
                        <h6 class="fw-semibold mb-1">Incumbent Change File</h6>
                        <p class="text-muted small mb-3">
                            Imports a batch of incumbent change transactions.
                        </p>
                        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-center gap-2">
                                <input type="file" name="importFileName5" accept=".csv" class="form-control form-control-sm">
                                <button type="submit" class="btn btn-sm btn-primary text-nowrap">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── Utilities (placeholder) ──────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold">Utilities</div>
                <div class="card-body text-muted small">
                    <p class="mb-1">Coming soon:</p>
                    <ul class="mb-0">
                        <li>Add position descriptions to "Reports To" assignments</li>
                        <li>Refresh demo / sample data</li>
                        <li>Bulk change position numbers</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
(function () {
    // Auto-dismiss success/warning after 6 seconds; errors stay until dismissed
    document.querySelectorAll('.alert-success.js-flash, .alert-warning.js-flash').forEach(function (el) {
        setTimeout(function () {
            bootstrap.Alert.getOrCreateInstance(el).close();
        }, 6000);
    });

    // Clear ALL alerts the moment a new file is chosen or any Upload button is clicked
    function clearFlash() {
        document.querySelectorAll('.js-flash').forEach(function (el) {
            bootstrap.Alert.getOrCreateInstance(el).close();
        });
    }

    document.querySelectorAll('input[type="file"]').forEach(function (el) {
        el.addEventListener('change', clearFlash);
    });
    document.querySelectorAll('button[type="submit"]').forEach(function (el) {
        el.addEventListener('click', clearFlash);
    });
})();
</script>

</body>
</html>
