<nav class="navbar navbar-expand navbar-dark px-4 py-0 shadow-sm" style="background-color:#1e3a5c; min-height:56px;">

    <a class="navbar-brand d-flex align-items-center gap-2 me-5 py-2 text-decoration-none" href="{{ route('dashboard') }}">
        <img src="{{ asset('/images/PowerPCS.png') }}" height="28" alt="PowerPCS">
        <span class="fw-bold text-white" style="letter-spacing:.05em; font-size:.95rem;">PowerPCS</span>
    </a>

    @php
        $navOn  = 'nav-link px-3 py-3 text-white fw-medium';
        $navOff = 'nav-link px-3 py-3 text-white-50';
    @endphp
    <div class="navbar-nav flex-row me-auto">
        <a href="/positions"               class="{{ request()->is('positions*')  ? $navOn : $navOff }}">Positions</a>
        <a href="/incumbents"              class="{{ request()->is('incumbents*') ? $navOn : $navOff }}">Incumbents</a>
        <a href="/reports"                 class="{{ request()->is('reports*')    ? $navOn : $navOff }}">Reports</a>
        <a href="{{ route('setup.show') }}" class="{{ request()->is('setup*')     ? $navOn : $navOff }}">Setup</a>
    </div>

    @auth
    <div class="d-flex align-items-center gap-3 small">
        <span class="text-white-50">{{ auth()->user()->currentTeam->name ?? '' }}</span>
        <span style="color:rgba(255,255,255,.2)">|</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link p-0 small text-white-50 text-decoration-none">Sign out</button>
        </form>
    </div>
    @endauth

</nav>
