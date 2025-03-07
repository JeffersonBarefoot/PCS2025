<!doctype html>
<html lang="en">

@include('positions.sections.head')

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

@include('positions.sections.script')

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
        @include('positions.sections.appnavbar')
    </div>

    {{--    --}}{{--    Row02 all contents except app navbar--}}
    <div class="row-lg-12">

        {{--        Col03 Data NavBar--}}
        <div class="col">
{{--            <div class="container-fluid">--}}
                {{--                Row04 DataNavBar filters, Row05 DataNavBar records (pulls in by include)--}}
                <div class="row">
                    <div class="col">
                        @include('positions.sections.datanavbar')
                    </div>
                </div>
{{--            </div>--}}
        </div>

        <div class="col">
            top of col 06<br>
            {{--                Col06<br>--}}
            {{--                <<<<<<< HEAD<br>--}}
            {{--                Row07--}}
            <div class="row">
                @include('positions.sections.Titles')
            </div>
            {{--                Row08--}}
            {{--                <div class="row">--}}
            {{--                    before--}}
            {{--                    @include('positions.sections.section1')--}}
            {{--                    after--}}
            {{--                </div>--}}
            {{--                Row09--}}
            {{--                <div class="row">--}}
            {{--                    @include('positions.sections.section2')--}}
            {{--                </div>--}}
            {{--                Row10 ***********************************************--}}
            {{--                =======--}}
            {{--                --}}{{--            --}}{{----}}{{--            Row07--}}
            {{--                <div class="row">--}}
            {{--                    ***Titles, Layout Row 7<br>--}}
            {{--                    @include('positions.sections.Titles')--}}
            {{--                </div>--}}

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
                        @include('positions.sections.section1')
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
                            @include('positions.sections.section2')
                        </div>
                    </div>
                </div>
                {{--            Row10 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 3, Layout Row 10<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection3" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Budget Variances
                        </a>
                    </p>
                    <div class="collapse" id="PosSection3">
                        <div class="card card-body">
                            @include('positions.sections.section3')
                        </div>
                    </div>
                </div>
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
                            @include('positions.sections.section4')
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
                            @include('positions.sections.section5')
                        </div>
                    </div>
                </div>
                {{--            Row13 ***********************************************--}}
{{--                @dump(" line 176")--}}
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
                                                        @include('positions.sections.section6')
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
                                                        @include('positions.sections.section7')
                        </div>
                    </div>
                </div>
                {{--            Row15 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
{{--                                                Section 8, Layout Row 15<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection8" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            User Defined Fields
                        </a>
                    </p>
                    <div class="collapse" id="PosSection8">
                        <div class="card card-body">
                                                        @include('positions.sections.section8')
                        </div>
                    </div>
                </div>
                {{--            Row16 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 9, Layout Row 16<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection9" role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Funding Sources
                        </a>
                    </p>
                    <div class="collapse" id="PosSection9">
                        <div class="card card-body">
                                                        @include('positions.sections.section9')
                        </div>
                    </div>
                </div>
                {{--            Row17 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 10, Layout Row 17<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection10"
                           role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Succession Planning
                        </a>
                    </p>
                    <div class="collapse" id="PosSection10">
                        <div class="card card-body">
                                                        @include('positions.sections.section10')
                        </div>
                    </div>
                </div>
                {{--            Row18 ***********************************************--}}
                <div class="row">
                    <p>
                        {{--                        ________________________________________<br>--}}
                        {{--                        Section 11, Layout Row 18<br>--}}
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection11"
                           role="button"
                           aria-expanded="false" aria-controls="collapseExample">
                            Allocations
                        </a>
                    </p>
                    <div class="collapse" id="PosSection11">
                        <div class="card card-body">
                                                        @include('positions.sections.section11')
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</body>
</html>








