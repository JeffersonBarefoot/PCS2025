<!doctype html>
<html lang="en">

@include('Common.001head')

<?php
$R201Show = sessionGet('R201Show');
$P201Show = sessionGet('P201Show');
$P204Show = sessionGet('P204Show');
?>

<body>
<div class="container-fluid">

    <div class="row">
        @include('Common.102appnavbar')
    </div>

    <div class="row">

        <div class="col-2">
            @include('reportbuilders.Sections.103datanavbar')
        </div>

        <div class="col-10 p-3">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 mb-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Title bar and Copy/Edit live OUTSIDE the filter form --}}
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-1">
                <h5 class="mb-0 fw-bold">{{ $report->descr }}</h5>
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-muted small me-1">{{ $report->group1 }}</span>
                    @if(!$report->is_system && $report->userid === Auth::id())
                        <a href="{{ route('reports.edit', $report->id) }}"
                           class="btn btn-sm btn-outline-secondary btn-action">
                            &#9998; Edit
                        </a>
                    @endif
                    <form action="{{ route('reports.copy', $report->id) }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary btn-action">
                            &#10064; Copy
                        </button>
                    </form>
                </div>
            </div>

            {{-- Filter form wraps only the parameters panel and data table --}}
            <form action="{{ route('reports.show', $report->id) }}" method="get">
                {{ csrf_field() }}

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection1" role="button">
                            Report Parameters
                        </a>
                        <div class="collapse show" id="RepSection1">
                            <div class="card mt-1">
                                <div class="card-body">
                                    @include('reportbuilders.Sections.201')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection3" role="button">
                            Report Data
                        </a>
                        <div class="collapse show" id="RepSection3">
                            <div class="card mt-1">
                                <div class="card-body p-0">
                                    @include('reportbuilders.Sections.203')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>

@include('Common.002script')

</body>
</html>
