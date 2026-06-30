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

    <form action="{{route('reports.show', $report->id)}}" method="get">
        {{ csrf_field() }}
        <div class="row">

            <div class="col-3">
                @include('reportbuilders.Sections.103datanavbar')
            </div>

            <div class="col-9 p-3">

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection1" role="button">
                            Report Parameters:
                        </a>
                        <div class="{{ $R201Show ? 'collapse show' : 'collapse' }}" id="RepSection1">
                            <div class="card mt-1">
                                <div class="card-body">
                                    @include('reports.Sections.201')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection2" role="button">
                            Summary:
                        </a>
                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection2">
                            <div class="card mt-1">
                                <div class="card-body">
                                    @include('reports.Sections.202')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection3" role="button">
                            Report Summary:
                        </a>
                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection3">
                            <div class="card mt-1">
                                <div class="card-body">
                                    @include('reports.Sections.203')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection4" role="button">
                            Report Detail:
                        </a>
                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection4">
                            <div class="card mt-1">
                                <div class="card-body">
                                    @include('reports.Sections.204')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

@include('Common.002script')

</body>
</html>
