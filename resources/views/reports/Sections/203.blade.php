<body>
<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
//?>



<h1 class="display-5">Section 3</h1>

{{--@foreach($positionsnavbar as $position)--}}
<?php
BarChart::create([
    "dataStore" => $positionsnavbar,
    "columns" => [
        "descr" => [
            "label" => "Customerxx"
        ],
        "budgsal" => [
            "type" => "number",
            "label" => "Amountxx",
            "prefix" => "$",
        ]
    ],
    "options" => [
        "title" => "Sales By Customer"
    ]
]);
?>
<?php
       Table::create([
           "dataStore" => $positionsnavbar,
           "columns" => [
               "descr" => [
                   "label" => "Customerxx"
               ],
               "budgsal" => [
                   "type" => "number",
                   "label" => "Amountxx",
                   "prefix" => "$",
               ]
           ],
           "cssClass" => [
               "table" => "table table-hover table-bordered"
           ]
       ]);
?>

</body>
