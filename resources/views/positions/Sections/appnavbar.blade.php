{{--<body>--}}


    appnavdiv - TopNavigation<br><br>

    Hello World, this is Position...<br><br>
    <br><br>
    {{"Positon ID:  ".$id}}<br>
    {{"Position Description:  ".$position->descr}}<br><br>

    <br><br><br><br>
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Back to the Dashboard') }}
    </x-nav-link>
    <br><br>


{{--</body>--}}
