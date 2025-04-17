<!doctype html>
<html lang="en">

@include('Common.001head')

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

{{--@include('Common.002script')--}}

{{--Check session vars for org level descriptions - text --}}
<?php $level1Description = sessionGet('level1Desc') ?>
<?php $level2Description = sessionGet('level2Desc') ?>
<?php $level3Description = sessionGet('level3Desc') ?>
<?php $level4Description = sessionGet('level4Desc') ?>
<?php $level5Description = sessionGet('level5Desc') ?>

{{--Check session vars for collapsible panel show-status - true/false--}}
<?php $P201Show = sessionGet('P201Show') ?>
<?php $P202Show = sessionGet('P202Show') ?>
<?php $P203Show = sessionGet('P203Show') ?>
<?php $P204Show = sessionGet('P204Show') ?>
<?php $P205Show = sessionGet('P205Show') ?>
<?php $P206Show = sessionGet('P206Show') ?>
<?php $P207Show = sessionGet('P207Show') ?>
<?php $P208Show = sessionGet('P208Show') ?>
<?php $P209Show = sessionGet('P209Show') ?>
<?php $P210Show = sessionGet('P210Show') ?>
<?php $P211Show = sessionGet('P211Show') ?>
<?php $P900Show = sessionGet('P900Show') ?>

{{--@dump($P201Show)--}}

<body>
<div class="container-fluid-xxl padding-left: 2">
    <div class="row">
        <div class="row g-2">
            {{--                    XXXTOP OF APPNAVBAR ROW--}}
            @include('Common.102appnavbar')
            {{--                    XXXBOTTOM OF APPNAVBAR ROW--}}
        </div>

        {{--    --}}{{--    Row02 all contents except app navbar--}}
        <div class="row">
            {{--                    XXX TOP OF CONTENT ROW--}}

            {{--        Col03 Data NavBar--}}
            <div class="col-xxl-3 margin-left: 5px">
                {{--                        XXX TOP OF NAVBAR COLUMN--}}
                {{--            <div class="container-fluid">--}}
                {{--                Row04 DataNavBar filters, Row05 DataNavBar records (pulls in by include)--}}
                <div class="row">
                    <div class="col">
                        @include('reports.Sections.103datanavbar')
                    </div>
                </div>
                {{--            </div>--}}
                {{--                        XXX BOTTOM OF NAVBAR COLUMN--}}
            </div>

            <div class="col xxl-9  p-5 m-1">
                {{--                        XXX TOP OF DATA COLUMN...all position specific data in collapsible panels--}}
                <div class="row">
{{--                    @include('positions.Sections.101Titles')--}}
                </div>

                {{--column c6--}}
                <div class="col">
                    {{--            Row08 ***********************************************--}}


                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="PosSection1">
                            <div class="card">
                                <div class="card-body">
{{--                                    @include('positions.Sections.201Status')--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--            Row09 ***********************************************--}}
                    <div class="row">
                        <p>
                            {{--                        ________________________________________<br>--}}
                            {{--                        Section 2, Layout Row 9<br>--}}
                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection2"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Budgets and FTEs
                            </a>
                        </p>
                        {{--                        <div class="collapse" id="PosSection2">--}}
                        <div class="{{ $P202Show ? 'collapse show' : 'collapse' }}" id="PosSection2">
                            <div class="card card-body">
{{--                                @include('positions.Sections.202budgets')--}}
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
                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection4"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Org Levels
                            </a>
                        </p>
                        {{--                        <div class="collapse" id="PosSection4">--}}
                        <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="PosSection4">
                            <div class="card card-body">
{{--                                @include('positions.Sections.204orglevels')--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

@include('Common.002script')

</html>








