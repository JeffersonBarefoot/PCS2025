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
{{--       {{Session::put("PSec201Show","collapse show")}}--}}
{{--//         $JEFFTEST = "COLLAPSE SHOW";--}}
{{--        console.log("show");--}}
{{--        myVariable = " COLLAPSE SHOW";--}}
{{--    });--}}
{{--    myCollapsible.addEventListener('hidden.bs.collapse', function () {--}}
{{--        // $JEFFTEST = "COLLAPSE";--}}
{{--        {{Session::put('PSec201Show', 'collapse')}}--}}
{{--    console.log('collapse');--}}
{{--        myVariable = " COLLAPSE";--}}
{{--    });--}}

// ***********************************************************
// ***********************************************************
// Manage Collapse/Show status of various collapsible panels
// Use JavaScript events to see if the status has changed
// Push that through a Route, to the Controller, to save to Session Var
// Pull the session Var into the blade and modify the collapse script as needed
// ***********************************************************
// ***********************************************************

// See if the Session Vars already exist.  If not, this is the first time running in this session, so initialize them



// See if the
document.addEventListener('DOMContentLoaded', function () {
    function PanelShowListener(divId,sessionVar) {
        var myCollapsible = document.getElementById(divId);
        if (myCollapsible) {
            myCollapsible.addEventListener('shown.bs.collapse', function () {
                // updateSession('collapse show');
                updateSession(sessionVar+"T");
            });
            myCollapsible.addEventListener('hidden.bs.collapse', function () {
                // console.log('collapse');
                // updateSession('collapse show');
                updateSession(sessionVar+"F");
            });
        } else {
            console.error('Element with ID "PosSection1" not found.');
        }
    }


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

    // PanelShowListener(HtmlDivId, SessionVariableName)
    PanelShowListener("PosSection1","P201Show");
    PanelShowListener("PosSection2","P202Show");
    // PanelShowListener("PosSection3","P203Show");
    PanelShowListener("PosSection4","P204Show");
    PanelShowListener("PosSection5","P205Show");
    PanelShowListener("PosSection6","P206Show");
    PanelShowListener("PosSection7","P207Show");
    // PanelShowListener("PosSection8","P208Show");
    // PanelShowListener("PosSection9","P209Show");
    // PanelShowListener("PosSection10","P210Show");
    // PanelShowListener("PosSection11","P211Show");
    PanelShowListener("PosSection11","P900Show");

});


</script>
