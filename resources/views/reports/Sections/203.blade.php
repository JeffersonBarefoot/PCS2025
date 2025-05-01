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
           "grouping" => array(
               "curstatus" => array(
                   "calculate" => array(
                       "{sumBudgSal}" => array("sum", "budgsal")
                   ),
                   "top" => "<b>Current Status {curstatus}</b>",
                   "bottom" => "<td><b>Total of Status {curstatus}</b></td><td><b>{sumBudgSal}</b></td>",
               ),
           ),
           "sorting" => ["curstatus" => "asc"],
           "showFooter"=>true,
           "columns" => [
               "company",
               "posno",
               "curstatus",
               "descr" =>       ["label" => "Customerxx"],
               "budgsal" =>     ["cssStyle"=>"text-align:right","label" => "Amountxx","type" => "number","prefix" => "$","footer"=>"sum","footerText"=>"Total:@value"],
               "budgsal",
           ],

       ]);
?>

</body>
