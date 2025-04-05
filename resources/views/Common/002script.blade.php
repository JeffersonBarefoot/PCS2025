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

    // These scripts successfully capture an un/collapsing element and save to Session
    // var myCollapsible = document.getElementById(`collapse_bar`)
{{--    var myCollapsible = document.getElementById(`PosSection1`);--}}
{{--    var myVariable = "";--}}

{{--    myCollapsible.addEventListener('shown.bs.collapse', function () {--}}
{{--       {{Session::put("PSec1StatusCode","collapse show")}}--}}
{{--//         $JEFFTEST = "COLLAPSE SHOW";--}}
{{--        console.log("show");--}}
{{--        myVariable = " COLLAPSE SHOW";--}}
{{--    });--}}
{{--    myCollapsible.addEventListener('hidden.bs.collapse', function () {--}}
{{--        // $JEFFTEST = "COLLAPSE";--}}
{{--        {{Session::put('PSec1StatusCode', 'collapse')}}--}}
{{--    console.log('collapse');--}}
{{--        myVariable = " COLLAPSE";--}}
{{--    });--}}

document.addEventListener('DOMContentLoaded', function () {
    var myCollapsible = document.getElementById('PosSection1');
    if (myCollapsible) {
        myCollapsible.addEventListener('shown.bs.collapse', function () {
            updateSession('collapse show');
        });
        myCollapsible.addEventListener('hidden.bs.collapse', function () {
            // console.log('collapse');
            updateSession('collapse');
        });
    } else {
        console.error('Element with ID "PosSection1" not found.');
    }
});

    function updateSession(status) {
        fetch('/update-collapse-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Session updated:', data);
            })
            .catch((error) => {
                // console.error('Error:', error);
            });
    }



</script>
