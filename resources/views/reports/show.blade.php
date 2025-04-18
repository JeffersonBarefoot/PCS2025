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
<!-- <form method="post" action="/reports" enctype="multipart/form-data"> -->
{{--<form action="{{route('reports.show',$report->id)}}" method="get">--}}
    {{ csrf_field() }}

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
                <div class="col color: divide-pink-400">
                    {{--            Section 01 ***********************************************--}}
                    <div class="row">
                        <p>
                            <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection1"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Report Parameters:
                            </a>
                        </p>

                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection1">
                            <div class="card">
                                <div class="card-body">
                                    @include('reports.Sections.201')
                                    {{--                                    @include('positions.Sections.201Status')--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--            Section 02 ***********************************************--}}
                    <div class="row">
                        <p>
                            <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection2"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Summary:
                            </a>
                        </p>

                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection2">
                            <div class="card">
                                <div class="card-body">
                                    @include('reports.Sections.202')
                                    {{--                                    @include('positions.Sections.201Status')--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--            Section 03 ***********************************************--}}
                    <div class="row">
                        <p>
                            <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection3"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Report Summary:
                            </a>
                        </p>

                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection3">
                            <div class="card">
                                <div class="card-body">
                                    @include('reports.Sections.203')
                                    {{--                                    @include('positions.Sections.201Status')--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--            Section 04 ***********************************************--}}
                    <div class="row">
                        <p>
                            <a class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#RepSection4"
                               role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Report Detail:
                            </a>
                        </p>

                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="RepSection4">
                            <div class="card">
                                <div class="card-body">
                                    @include('reports.Sections.204')
                                    {{--                                    @include('positions.Sections.201Status')--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initExpands() {

            sessionStorage.setItem("initialized", "expandStatus");
        }

        function expandStatus() {
            var x = document.getElementById("p2").getAttribute("aria-expanded");
            if (x == " class='panel-collapse collapse' id='collapse1' ") {
                x = " class='panel-collapse' id='collapse1' ";
            } else {
                x = " class='panel-collapse collapse' id='collapse1' ";
            }

            // document.getElementById("p2").setAttribute("aria-expanded", x);
            // document.getElementById("p2").innerHTML = "aria-expanded =" + x;

            if (typeof (Storage) !== "undefined") {
                if (sessionStorage.expandStatus) {
                    // sessionStorage.expandStatus = Number(sessionStorage.clickcount)+2;
                    sessionStorage.expandStatus = x;
                }
                // } else {
                //   sessionStorage.expandStatus = 1;
                // }
                document.getElementById("demo123").innerHTML = x;
            } else {
                document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
            }
        }

        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>

</body>

@include('Common.002script')

</html>








