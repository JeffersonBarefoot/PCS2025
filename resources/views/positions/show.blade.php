<!doctype html>
<html lang="en">
<head>
    {{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">--}}
{{--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
    {{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}

    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .appnavdiv {
            border: 5px outset #ff00e5;
            background-color: #83d609;
            text-align: center;
        }
    </style>
    <title></title>

</head>

<style>
    .myDiv {
        border: 5px outset red;
        background-color: lightblue;
        text-align: center;
    }
</style>

<!-- set this to readonly to make this a show screen, or something else (blank, notreadonly, etc) to allow editing  -->
<!-- note that for UNCHECKED radio buttons you have to use [disabled] instead of [readonly].  CHECKED radio buttons remain active-->
<?php $readonly = Session::get('readOnlyText') ?>
<?php $disabled = Session::get('disabledText') ?>
<?php $expandPositionHistory = Session::get('ExpandPositionHistory') ?>
<?php $expandIncumbentHistory = Session::get('ExpandIncumbentHistory') ?>

<body>

{{--{{ Form::model($position, array('route' => array('positions.update', $position->id), 'method' => 'PUT')) }}--}}

<!-- *************************** -->
<!-- ************************** -->
<!-- ************************** -->
<script>

    // $(function () {
    //     $('[data-toggle="tooltip"]').tooltip();
    // })

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

    // This function runs when the value of one of the Budget fields is changed by the user
    function updateBudgetValues() {

        var nAnnFteHour, cFteFreq, nFteHours, nFullTimeEquiv, cPayFreq, nPayRate, nDummyFullTimeEquiv, nBudgSal,
            nPayPeriods, nFtePeriods;

        // Gather values that user has input
        // from the left column:
        nAnnFteHour = document.getElementById('annftehour').value;
        cFteFreq = document.getElementById('ftefreq').value;
        cFteFreq = cFteFreq.substring(0, 1);
        cFteFreq = cFteFreq.toUpperCase();
        nFteHours = document.getElementById('ftehours').value;
        nFullTimeEquiv = document.getElementById('fulltimeequiv').value;
        // from the right column
        cPayFreq = document.getElementById('payfreq').value;
        cPayFreq = cPayFreq.substring(0, 1);
        cPayFreq = cPayFreq.toUpperCase();
        nPayRate = document.getElementById('payrate').value;
        nPayRate = nPayRate.replace('$', '');
        nPayRate = nPayRate.replace(',', '');
        nDummyFullTimeEquiv = document.getElementById('dummyfulltimeequiv').value;
        nBudgSal = document.getElementById('budgsal').value;

        // validate data
        // FTEFreq fields should only be W, B, S, M or A
        // PayFreq fields should only be H, W, B, S, M or A


        // calc # of pay periods
        switch (cFteFreq) {
            case 'W':
                nFtePeriods = 52;
                break;

            case 'B':
                nFtePeriods = 26;
                break;

            case 'S':
                nFtePeriods = 24;
                break;

            case 'M':
                nFtePeriods = 12;
                break;

            case 'A':
                nFtePeriods = 1;
                break;
        }

        // calc # of pay periods
        switch (cPayFreq) {
            case 'H':
                nPayPeriods = nAnnFteHour;
                break;

            case 'W':
                nPayPeriods = 52;
                break;

            case 'B':
                nPayPeriods = 26;
                break;

            case 'S':
                nPayPeriods = 24;
                break;

            case 'M':
                nPayPeriods = 12;
                break;

            case 'A':
                nPayPeriods = 1;
                break;
        }


        // Calc # of FTEs
        nFullTimeEquiv = (nFteHours * nFtePeriods) / nAnnFteHour

        //Calc Budgeted Salary
        nBudgSal = nPayRate * nPayPeriods * nFullTimeEquiv

        // update all fields
        document.getElementById("fulltimeequiv").setAttribute('value', nFullTimeEquiv);
        document.getElementById("dummyfulltimeequiv").setAttribute('value', nFullTimeEquiv);
        document.getElementById("budgsal").setAttribute('value', nBudgSal);
    }


</script>


{{--pt-5 = padding at top of 5 (large)--}}
<div class="container-fluid">
    {{--    Row01--}}




        Row02
    <div class="row">
            Col03
        <div class="col-sm span-5">
                        <div class="container-fluid">
                    Row04, Row05 (pulls in by include)
            <div class="row">
                <div class="col">
                    @include('positions.sections.datanavbar')
                </div>
            </div>
        </div>
                Col06
        <div class="col">
                                    Row07
                        <div class="row">
                            @include('positions.sections.Titles')
                        </div>
                                    Row08
                        <div class="row">
                            @include('positions.sections.section1')
                        </div>
                                    Row09
                        <div class="row">
                            @include('positions.sections.section2')
                        </div>
                        Row10  ***********************************************
            <div class="row">
                <p>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#PosSection3" role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        Link with href
                    </a>
                </p>
                <div class="collapse" id="PosSection3">
                    <div class="card card-body">
                        Some placeholder content for the collapse component. This panel is hidden by default but
                        revealed when the user activates the relevant trigger.
                    </div>
                </div>
            </div>
                        Row11 ***********************************************
            <div class="row">
                <p>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#PosSection3" role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        Link with href
                    </a>
                </p>
                <div class="collapse" id="PosSection3">
                    <div class="card card-body">
                        xxSome placeholder content for the collapse component. This panel is hidden by default but
                        revealed when the user activates the relevant trigger.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <div class="col-sm span-5">
        <div class="row">
                @include('positions.sections.section1')
        </div>
    </div>
    <div class="col-sm span-5">
        <div class="row">
            <div class="col">
                @include('positions.sections.section2')
            </div>
        </div>
    </div>
    <div class="col-sm span-5">
        <div class="row">
            <div class="col">
                @include('positions.sections.section3')
            </div>
        </div>
    </div>
    <div class="col-sm span-5">
        <div class="row">
            <div class="col">
                @include('positions.sections.section4')
            </div>
        </div>
    </div>
</body>
</html>








