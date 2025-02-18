{{--To test all of these examples:  http://pcs2025.test/postest/5--}}

{{--YIELD example.  This works with the YIELD example in postest.navbar--}}
{{--@extends('postest.navbar')--}}
{{--@section('navbarsection99')--}}
{{--    Hello World, this is postest<br><br>--}}
{{--    {{"Positon ID:  ".$id}}<br>--}}
{{--    {{"Position Description:  ".$position->descr}}<br><br>--}}
{{--    {{$test}}<br>--}}
{{--    {{$test2}}<br>--}}
{{--    {{$test3}}<br>--}}
{{--@endsection()--}}
{{--END YIELD EXAMPLE--}}

{{--INCLUDE example.  This works with the INCLUDE example in postest.navbar--}}
{{--@include('postest.navbar')--}}
{{--END INCLUDE EXAMPLE--}}

{{--MULTIPLE INCLUDE example.  This works with the various files called out below--}}
@include('postest.Sections.datanavbar')<br>
@include('postest.Sections.appnavbar')<br>
@include('postest.Sections.titles')<br>
@include('postest.Sections.section1')
@include('postest.Sections.section2')
@include('postest.Sections.section3')
@include('postest.Sections.section4')
{{--END MULTIPLE INCLUDE EXAMPLE--}}

<!DOCTYPE html>
<html>
<head>
    <style>
        .myDiv {
            border: 5px outset red;
            background-color: lightblue;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>The div element</h1>

<div class="myDiv">
    <h2>This is a heading in a div element</h2>
    <p>This is some text in a div element.</p>
</div>

<p>This is some text outside the div element.</p>
</body>
</html>
