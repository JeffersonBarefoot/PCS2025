<body>
    appnavdiv - TopNavigation<br>
    Hello World, this is Position...<br>
    {{"Positon ID:  ".$id}}<br>
    {{"Position Description:  ".$position->descr}}<br>
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Back to the Dashboard') }}
    </x-nav-link>
</body>
