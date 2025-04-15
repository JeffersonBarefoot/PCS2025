{{--<body>--}}
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Back to the Dashboard') }}
    </x-nav-link>



<a href='/positions/4'>Go To Position #4</a>
<a href='/incumbents/57'>Go To Incumbent #57</a>
