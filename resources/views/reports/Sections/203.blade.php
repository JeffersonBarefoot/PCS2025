<body>
<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
//?>



<h1 class="display-5">Section 3</h1>

{{--@foreach($positionsnavbar as $position)--}}
<!----><?php
//BarChart::create(array(
//    "dataStore"=>$positionsnavbar,
//    "width"=>"100%",
//    "height"=>"500px",
//    "columns"=>array(
//        "descr"=>array(
//            "label"=>"Customer"
//        ),
//        "ftehrs"=>array(
//            "type"=>"number",
//            "label"=>"Amount",
//            "prefix"=>"$",
//        )
//    ),
//    "options"=>array(
//        "title"=>"Sales By Customer"
//    )
//));
//?>
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
