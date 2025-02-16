<?php

echo "xxx404 - you tried to post a page with no ID:  Positions:  Hello World!";




?>

{{--@dump("Blade ID:")--}}
{{--@dump($id)--}}
<br><br><br><br>
{{$id}}<br>
{{$test}}<br>
{{$test2}}<br>
{{$test3}}<br>

<br><br><br><br>
<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ __('Back to the Dashboard') }}
</x-nav-link>

{{--{{round($position->fulltimeequiv,3)}} FTEs / {{$position->budgsal}}--}}
