<!doctype html>
<html lang="en">

@include('positions.Sections.001head')

{{--<style>--}}
{{--    .myDiv {--}}
{{--        border: 5px outset red;--}}
{{--        background-color: lightblue;--}}
{{--        text-align: center;--}}
{{--    }--}}
{{--</style>--}}

{{--<!-- set this to readonly to make this a show screen, or something else (blank, notreadonly, etc) to allow editing  -->--}}
{{--<!-- note that for UNCHECKED radio buttons you have to use [disabled] instead of [readonly].  CHECKED radio buttons remain active-->--}}
<?php $readonly = Session::get('readOnlyText') ?>
<?php $disabled = Session::get('disabledText') ?>
<?php $expandPositionHistory = Session::get('ExpandPositionHistory') ?>
<?php $expandIncumbentHistory = Session::get('ExpandIncumbentHistory') ?>

@include('positions.Sections.002script')

<body>
{{--@dump($request)--}}
{{--{{ Form::model($position, array('route' => array('positions.update', $position->id), 'method' => 'PUT')) }}--}}

<!-- *************************** -->
<!-- ************************** -->
<!-- ************************** -->


{{--pt-5 = padding at top of 5 (large)--}}
<div class="container-fluid">
    {{--    --}}{{--    Row01  AppNavBar--}}

    <div class="row-12">
        @include('positions.Sections.102appnavbar')
    </div>

    {{--    --}}{{--    Row02 all contents except app navbar--}}
    <div class="row-lg-12">

        {{--        Col03 Data NavBar--}}
        <div class="col">
            {{--            <div class="container-fluid">--}}
            {{--                Row04 DataNavBar filters, Row05 DataNavBar records (pulls in by include)--}}
            <div class="row">
                <div class="col">
                    @include('positions.Sections.103datanavbar')
                </div>
            </div>
            {{--            </div>--}}
        </div>

        <div class="col">
            <div class="row">
                @include('positions.Sections.101Titles')
            </div>

            {{--column c6--}}
            <div class="col">

                {{--            Row08 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 1, Layout Row 8 <br>--}}
                        {{--                    @dump($position)--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection1" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Position Status:
                            Currently
                            @if ($position->active=="A")
                                Active,
                            @else
                                Inactive,
                            @endif
                            {{ ucwords(strtolower($position->curstatus)) }}
                        </a>
                    </p>
                    <div class="collapse" id="PosSection1">
                        @include('positions.Sections.201Status')
                    </div>
                </div>

                {{--            Row09 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 2, Layout Row 9<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection2" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Budgets and FTEs
                        </a>
                    </p>
                    <div class="collapse" id="PosSection2">
                        <div class="card card-body">
                            @include('positions.Sections.202budgets')
                        </div>
                    </div>
                </div>

{{--                --}}{{--            Row10 ***********************************************--}}
{{--                <div class="row">--}}
{{--                    <p>--}}
{{--                        --}}{{--                        ________________________________________<br>--}}
{{--                        --}}{{--                        Section 3, Layout Row 10<br>--}}
{{--                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection3" role="button"--}}
{{--                           aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            Budget Variances--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="PosSection3">--}}
{{--                        <div class="card card-body">--}}
{{--                            @include('positions.Sections.203budvar')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{--                Row11 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 4, Layout Row 11<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection4" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Org Levels
                        </a>
                    </p>
                    <div class="collapse" id="PosSection4">
                        <div class="card card-body">
                            <<<<<<< HEAD
                            xxSome placeholder content for the collapse component. This panel is hidden by
                            default
                            but
                            revealed when the user activates the relevant trigger.
                            =======
                            @include('positions.Sections.204orglevels')
                        </div>
                    </div>
                </div>

                {{--            Row12 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 5, Layout Row 12<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection5" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Reports To
                        </a>
                    </p>
                    <div class="collapse" id="PosSection5">
                        <div class="card card-body">
                            @include('positions.Sections.205reportsto')
                        </div>
                    </div>
                </div>

                {{--            Row13 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 6, Layout Row 13<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection6" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Incumbents
                        </a>
                    </p>
                    <div class="collapse" id="PosSection6">
                        <div class="card card-body">
                            @include('positions.Sections.206Incum')
                        </div>
                    </div>
                </div>

                {{--            Row14 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 7, Layout Row 14<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection7" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Position History
                        </a>
                    </p>
                    <div class="collapse" id="PosSection7">
                        <div class="card card-body">
                            @include('positions.Sections.207poshist')
                        </div>
                    </div>
                </div>

{{--                --}}{{--            Row15 ***********************************************--}}
{{--                <div class="row">--}}
{{--                    <p>--}}
{{--                        --}}{{--                        ________________________________________<br>--}}
{{--                        --}}{{--                                                Section 8, Layout Row 15<br>--}}
{{--                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection8" role="button"--}}
{{--                           aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            User Defined Fields--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="PosSection8">--}}
{{--                        <div class="card card-body">--}}
{{--                            @include('positions.Sections.208userdef')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--            Row16 ***********************************************--}}
{{--                <div class="row">--}}
{{--                    <p>--}}
{{--                        --}}{{--                        ________________________________________<br>--}}
{{--                        --}}{{--                        Section 9, Layout Row 16<br>--}}
{{--                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection9" role="button"--}}
{{--                           aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            Funding Sources--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="PosSection9">--}}
{{--                        <div class="card card-body">--}}
{{--                            @include('positions.Sections.209funding')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--            Row17 ***********************************************--}}
{{--                <div class="row">--}}
{{--                    <p>--}}
{{--                        --}}{{--                        ________________________________________<br>--}}
{{--                        --}}{{--                        Section 10, Layout Row 17<br>--}}
{{--                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection10"--}}
{{--                           role="button"--}}
{{--                           aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            Succession Planning--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="PosSection10">--}}
{{--                        <div class="card card-body">--}}
{{--                            @include('positions.Sections.210succession')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--            Row18 ***********************************************--}}
{{--                <div class="row">--}}
{{--                    <p>--}}
{{--                        --}}{{--                        ________________________________________<br>--}}
{{--                        --}}{{--                        Section 11, Layout Row 18<br>--}}
{{--                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection11"--}}
{{--                           role="button"--}}
{{--                           aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            Allocations--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="PosSection11">--}}
{{--                        <div class="card card-body">--}}
{{--                            @include('positions.Sections.211alloc')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


            </div>
        </div>
    </div>
</div>
</body>
</html>








