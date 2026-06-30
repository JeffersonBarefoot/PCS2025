
<?php

use koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;

//?
//?>


<h1 class="display-5">Section 3</h1>

<div style="max-width: 50%; overflow-x: auto;">
<!----><?php
//BarChart::create([
//    "dataStore" => $reportarray,
//    "columns" => [
//        "descr" => [
//            "label" => "Customerxx"
//        ],
//        "budgsal" => [
//            "type" => "number",
//            "label" => "xAmountxx",
//            "prefix" => "$",
//        ]
//    ],
//    "options" => [
//        "title" => "Sales By Customer"
//    ]
//]);
//?>
</div>

<?php
Table::create([
    "dataStore" => $reportarray,
    "cssClass" => "KoolReport-Report"
]);
?>

