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

