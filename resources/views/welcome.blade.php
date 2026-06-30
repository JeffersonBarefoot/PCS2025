<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PowerPCS &mdash; Position Control System</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { font-family: 'Figtree', sans-serif; background: #0f172a; color: #fff; margin: 0; }
                a { text-decoration: none; }
            </style>
        @endif
    </head>
    <body class="font-sans antialiased">

        {{-- Navigation --}}
        <header class="fixed top-0 inset-x-0 z-50 backdrop-blur" style="background-color: rgba(15,23,42,0.95); border-bottom: 1px solid #1e293b; z-index: 50; position: fixed; top: 0; left: 0; right: 0;">
            <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-bold text-base leading-none">PowerPCS</span>
                        <span class="text-slate-500 text-xs block leading-none mt-0.5">by Infisoft</span>
                    </div>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-slate-300 hover:text-white text-sm font-medium transition px-3 py-2">
                                Log In
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition">
                                    Create Account
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        {{-- Hero --}}
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16"
                 style="background-color: #0f172a;">
            <div class="absolute inset-0 pointer-events-none"
                 style="background: linear-gradient(135deg, rgba(30,58,138,0.5) 0%, transparent 60%);"></div>

            {{-- Subtle grid overlay --}}
            <div class="absolute inset-0 pointer-events-none"
                 style="background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 48px 48px;">
            </div>

            <div class="relative max-w-4xl mx-auto px-6 py-24 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-8 tracking-wide"
                     style="background: rgba(30,58,138,0.4); border: 1px solid rgba(59,130,246,0.35); border-radius: 9999px; color: #93c5fd; font-size: 0.75rem; font-weight: 600;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#60a5fa; display:inline-block;"></span>
                    Enterprise Position Control Software
                </div>

                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6" style="color: #ffffff; background: transparent;">
                    Know exactly who fills<br>
                    <span style="background: linear-gradient(90deg, #60a5fa, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">every position</span><br>
                    in your organization
                </h1>

                <p class="text-lg leading-relaxed mb-10 max-w-2xl mx-auto" style="color: #94a3b8;">
                    PowerPCS gives HR and finance teams a single source of truth for headcount &mdash;
                    tracking authorized positions, incumbents, FTE allocations, compensation budgets,
                    and organizational hierarchy in one place.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-500 transition text-sm shadow-lg shadow-blue-900/50">
                            Open Dashboard
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-500 transition text-sm shadow-lg shadow-blue-900/50">
                            Log In
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-lg border border-slate-600 text-slate-300 hover:text-white hover:border-slate-400 font-semibold transition text-sm">
                                Create an Account
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section class="bg-white py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Built for organizations that need precision</h2>
                    <p class="text-slate-500 max-w-xl mx-auto text-sm leading-relaxed">
                        Position control keeps headcount decisions grounded in authorized structure, not just
                        who happens to be on payroll today.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-6 rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mb-4 group-hover:bg-blue-600 transition">
                            <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Position Management</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Define and manage every authorized position. Track status, classification, budget, and organizational placement. Positions exist independent of the people who fill them.</p>
                    </div>

                    <div class="p-6 rounded-xl border border-slate-200 hover:border-cyan-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center mb-4 group-hover:bg-cyan-600 transition">
                            <svg class="w-5 h-5 text-cyan-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Incumbent Tracking</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Assign employees to positions with full history. A single employee can span multiple positions; a position can hold multiple incumbents &mdash; all tracked precisely by FTE allocation.</p>
                    </div>

                    <div class="p-6 rounded-xl border border-slate-200 hover:border-emerald-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mb-4 group-hover:bg-emerald-600 transition">
                            <svg class="w-5 h-5 text-emerald-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">FTE &amp; Budget Analysis</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Monitor FTE allocations, salary budgets, and annualized costs across positions and departments. Identify over- and under-utilized positions at a glance.</p>
                    </div>

                    <div class="p-6 rounded-xl border border-slate-200 hover:border-violet-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center mb-4 group-hover:bg-violet-600 transition">
                            <svg class="w-5 h-5 text-violet-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Organizational Hierarchy</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Map positions across up to five org levels. Configurable labels adapt to your naming conventions &mdash; division, department, unit, cost center, or any custom structure.</p>
                    </div>

                    <div class="p-6 rounded-xl border border-slate-200 hover:border-amber-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mb-4 group-hover:bg-amber-600 transition">
                            <svg class="w-5 h-5 text-amber-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Custom Reports</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Build position control reports with configurable columns and filters. Export to CSV for downstream use in finance and payroll systems.</p>
                    </div>

                    <div class="p-6 rounded-xl border border-slate-200 hover:border-rose-300 hover:shadow-lg transition group">
                        <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center mb-4 group-hover:bg-rose-600 transition">
                            <svg class="w-5 h-5 text-rose-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Multi-Tenant SaaS</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Each organization's data is fully isolated. Team-based architecture with role-based access controls keeps your headcount data private and secure.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How It Works --}}
        <section class="bg-slate-50 py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">How position control works</h2>
                    <p class="text-slate-500 max-w-lg mx-auto text-sm">Three layers of data tell the complete workforce story.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8">
                        <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg shadow-blue-200">1</div>
                        <h3 class="font-semibold text-slate-900 text-lg mb-3">Define Positions</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Create authorized positions with classification codes, budget targets, and organizational placement. Positions exist independently of the people who fill them.</p>
                    </div>
                    <div class="text-center p-8">
                        <div class="w-16 h-16 rounded-2xl bg-cyan-600 text-white flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg shadow-cyan-200">2</div>
                        <h3 class="font-semibold text-slate-900 text-lg mb-3">Assign Incumbents</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Attach employees to positions with FTE amounts. Track start and end dates, compensation, and full history. One employee can hold multiple positions simultaneously.</p>
                    </div>
                    <div class="text-center p-8">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg shadow-emerald-200">3</div>
                        <h3 class="font-semibold text-slate-900 text-lg mb-3">Analyze &amp; Report</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Run reports across positions, incumbents, budgets, and org levels. Compare budgeted vs. actual FTEs and identify vacancies, overages, and cost trends.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="bg-blue-700 py-16">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-white mb-3">Ready to get started?</h2>
                <p class="text-blue-200 mb-8 text-sm">Create your account and begin building your position control structure today.</p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-white text-blue-700 font-semibold text-sm hover:bg-blue-50 transition shadow-lg">
                            Go to Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-white text-blue-700 font-semibold text-sm hover:bg-blue-50 transition shadow-lg">
                                Create an Account
                            </a>
                        @endif
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-8 py-3 rounded-lg border border-blue-400 text-white font-semibold text-sm hover:bg-blue-600 transition">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-10" style="background-color: #0f172a; border-top: 1px solid #1e293b;">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-semibold text-sm">PowerPCS</span>
                        <span class="text-slate-500 text-sm"> &mdash; Position Control System</span>
                    </div>
                </div>
                <p class="text-slate-600 text-xs">&copy; {{ date('Y') }} Infisoft. All rights reserved.</p>
            </div>
        </footer>

    </body>
</html>
