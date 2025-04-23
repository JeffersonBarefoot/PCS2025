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
<?php $expandincumbentHistory = Session::get('ExpandincumbentHistory') ?>
<?php $expandIncumbentHistory = Session::get('ExpandIncumbentHistory') ?>

@include('Common.002script')

<?php $level1Description = sessionGet('level1Desc') ?>
<?php $level2Description = sessionGet('level2Desc') ?>
<?php $level3Description = sessionGet('level3Desc') ?>
<?php $level4Description = sessionGet('level4Desc') ?>
<?php $level5Description = sessionGet('level5Desc') ?>




        <body>
        <div class="col">


            {{--<main class="mt-6">--}}
            <div class="container-fluid p-2 m-5 bg-gray-100 text-gray-600">
                {{--    <div class="row  p-1 m-1">--}}
                {{--@dump($request)--}}
                {{--{{ Form::model($incumbent, array('route' => array('incumbents.update', $incumbent->id), 'method' => 'PUT')) }}--}}

                <!-- *************************** -->
                <!-- ************************** -->
                <!-- ************************** -->


                {{--pt-5 = padding at top of 5 (large)--}}
                {{--            <div class="container-fluid">--}}
                {{--                XXXTOP OF CONTAINER--}}
                {{--    --}}{{--    Row01  AppNavBar--}}

                <div class="row p-1 m-1">
                    {{--                    XXXTOP OF APPNAVBAR ROW--}}
                    @include('Common.102appnavbar')
                    {{--                    XXXBOTTOM OF APPNAVBAR ROW--}}
                </div>

                {{--    --}}{{--    Row02 all contents except app navbar--}}
                <div class="row">
                    {{--                    XXX TOP OF CONTENT ROW--}}

                    {{--        Col03 Data NavBar--}}
                    <div class="col-sm-3  p-1 m-1">
                        {{--                        XXX TOP OF NAVBAR COLUMN--}}
                        {{--            <div class="container-fluid">--}}
                        {{--                Row04 DataNavBar filters, Row05 DataNavBar records (pulls in by include)--}}
                        <div class="row">
                            <div class="col">
                                @include('incumbents.Sections.103datanavbar')
                            </div>
                        </div>
                        {{--            </div>--}}
                        {{--                        XXX BOTTOM OF NAVBAR COLUMN--}}
                    </div>

                    <div class="col sm-9  p-5 m-1">
                        {{--                        XXX TOP OF DATA COLUMN...all incumbent specific data in collapsible panels--}}
                        <div class="row">
                            @include('incumbents.Sections.101Titles')
                        </div>

                        {{--column c6--}}
                        <div class="col">

                            {{--            Row08 ***********************************************--}}
                            <div class="row">
                                <p>
                                    {{--                        ________________________________________<br>--}}
                                    {{--                        Section 1, Layout Row 8 <br>--}}
                                    {{--                    @dump($incumbent)--}}
                                    <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#PosSection1"
                                       role="button"
                                       aria-expanded="false" aria-controls="collapseExample">
                                        incumbent Status:
                                        Currently
                                        @if ($incumbent->active=="A")
                                            Active,
                                        @else
                                            Inactive,
                                        @endif
                                        {{ ucwords(strtolower($incumbent->curstatus)) }}
                                    </a>
                                </p>
                                <div class="collapse" id="PosSection1">
                                    <div class="card">
                                        <div class="card-body">
                                            @include('incumbents.Sections.201Status')
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
                                <div class="collapse" id="PosSection2">
                                    <div class="card card-body">
                                        @include('incumbents.Sections.202budgets')
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection3" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Organization
                            </a>
                            </p>
                            <div class="collapse" id="PosSection3">
                                <div class="card card-body">
                                    @include('incumbents.Sections.203Organization')
                                </div>
                            </div>
                        </div>

                        {{--                Row11 ***********************************************--}}
                        <div class="row">
                            <p>
                                {{--                        ________________________________________<br>--}}
                                {{--                        Section 4, Layout Row 11<br>--}}
                                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#PosSection4"
                                   role="button"
                                   aria-expanded="false" aria-controls="collapseExample">
                                    History
                                </a>
                            </p>
                            <div class="collapse" id="PosSection4">
                                <div class="card card-body">
                                    <div class="card card-body">
                                        @include('incumbents.Sections.204History')
                                    </div>

                                    {{--                                @include('incumbents.Sections.204orglevels')--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </body>

</html>








