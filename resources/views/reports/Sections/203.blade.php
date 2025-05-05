
<?php

use koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;

//?
?>


<h1 class="display-5">Section 3</h1>

<div style="max-width: 50%; overflow-x: auto;">
<?php
BarChart::create([
    "dataStore" => $reportarray,
    "columns" => [
        "descr" => [
            "label" => "Customerxx"
        ],
        "budgsal" => [
            "type" => "number",
            "label" => "xAmountxx",
            "prefix" => "$",
        ]
    ],
    "options" => [
        "title" => "Sales By Customer"
    ]
]);
//?>
</div>

<?php
Table::create([
    "dataStore" => $reportarray,
//    "grouping" => array(
//        "curstatus" => array(
//            "calculate" => array(
//                "{sumBudgSal}" => array("sum", "budgsal")
//            ),
//            "top" => "<b>Current Status {curstatus}</b>",
//            "bottom" => "<td><b>Total of Status {curstatus}</b></td><td><b>{sumBudgSal}</b></td>",
//        ),
//    ),
//    "sorting" => ["curstatus" => "asc"],
//    "showFooter" => true,
//    "columns" => [
//        "company",
//        "posno",
//        "curstatus",
//        "descr" => ["label" => "Customerxx"],
//        "budgsal" => ["cssStyle" => "text-align:right", "label" => "Amountxx", "type" => "number", "prefix" => "$", "footer" => "sum", "footerText" => "Total:@value"],
//        "budgsal",
//    ],

]);
?>

