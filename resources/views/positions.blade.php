<?php

echo "Positions:  Hello World!";

?>

{{--@dump("Blade ID:")--}}
{{--@dump($id)--}}
<br><br><br><br>


<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
{{ __('Back to the Dashboard') }}
</x-nav-link>

{{--{{round($position->fulltimeequiv,3)}} FTEs / {{$position->budgsal}}--}}


