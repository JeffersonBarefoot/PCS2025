<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>

    </style>
    <title></title>

</head>

Hello World, this is Position<br><br>
<br><br>
{{"Positon ID:  ".$id}}<br>
{{"Position Description:  ".$position->descr}}<br><br>

{{--{{$test}}<br>--}}
{{--{{$test2}}<br>--}}
{{--{{$test3}}<br>--}}

<br><br><br><br>
<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
{{ __('Back to the Dashboard') }}
</x-nav-link><br><br>

{{--<home :user="user" inline-template>--}}
{{--<home inline-template>--}}
{{--    <div class="container-fluid">--}}
{{--        <!-- Application Dashboard -->--}}
{{--        <!-- <div class="row justify-content-center"> -->--}}
{{--        <div class="row">--}}
{{--            <!-- <div class="col-md-8"> -->--}}
{{--            <div class="col">--}}
{{--                <!-- <div class="card card-default"> -->--}}
This is where the nav bar goes when we get it working.<br>
                <!-- test verbiage -->
@include('positions.sections.datanavbar')

{{--                <!-- </div> -->--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}

{{--</home>--}}

<!-- ************************** -->
<!-- ************************** -->
<!-- bootstrap sample -->
<!-- ************************** -->
<!-- ************************** -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-md-2">
                    <a data-toggle="collapse" href="#collapse6">Sample Title</a>
                </div>
                <div class="col-md-10">
                </div>
            </div>
        </h4>
    </div>
    <div id="collapse6" class="panel-collapse collapse">
        <div class="panel-body">xxxx Bootstrap collapsable div xxxx

        </div>
    </div>
</div>

{{--{{round($position->fulltimeequiv,3)}} FTEs / {{$position->budgsal}}--}}


