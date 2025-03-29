{{--<body>--}}
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Back to the Dashboard') }}
    </x-nav-link>



<a href='/positions/4'>Go To Position #4</a>
<a href='/positions/5'>Go To Position #5</a>
<a href='/positions/6'>Go To Position #6</a>
<a href='/positions/7'>Go To Position #7</a>
<a href='/positions/'>Go To 404 not found</a>

<a href='/incumbents/55'>Go To Incumbent #55</a>
<a href='/incumbents/56'>Go To Incumbent #56</a>
<a href='/incumbents/57'>Go To Incumbent #57</a>
