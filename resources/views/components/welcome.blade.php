@php
    use Illuminate\Support\Facades\DB;
    $teamId = Auth::user()->currentTeam->id;

    $totalPositions  = DB::table('positions')->where('teamid', $teamId)->count();
    $activePositions = DB::table('positions')->where('teamid', $teamId)->where('active', 'A')->count();
    $totalIncumbents = DB::table('incumbents')->where('teamid', $teamId)->where('active', 'A')->count();
    $totalFTEs       = DB::table('incumbents')->where('teamid', $teamId)->where('active', 'A')->sum('fulltimeequiv');
    $totalFTEs       = round($totalFTEs, 2);
@endphp

{{-- Dashboard header --}}
<div style="background-color: #1e3a8a; padding: 32px;">

    <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
        <div style="width:28px; height:28px; display:flex; align-items:center; justify-content:center; background:rgba(96,165,250,0.2); border:1px solid rgba(147,197,253,0.3); border-radius:6px;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="color:#fff;">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
        </div>
        <span style="font-size:11px; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:#93c5fd;">PowerPCS</span>
    </div>

    <h1 style="font-size:24px; font-weight:700; color:#ffffff; background: transparent; margin:0 0 4px 0;">
        Welcome back, {{ Auth::user()->name }}
    </h1>
    <div style="font-size:14px; color:#93c5fd; margin:0 0 24px 0;">{{ Auth::user()->currentTeam->name }}</div>

    {{-- Stat strip --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px;">
        <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:12px 16px;">
            <div style="font-size:24px; font-weight:700; color:#ffffff;">{{ number_format($totalPositions) }}</div>
            <div style="font-size:11px; color:#bfdbfe; margin-top:2px;">Total Positions</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:12px 16px;">
            <div style="font-size:24px; font-weight:700; color:#ffffff;">{{ number_format($activePositions) }}</div>
            <div style="font-size:11px; color:#bfdbfe; margin-top:2px;">Active Positions</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:12px 16px;">
            <div style="font-size:24px; font-weight:700; color:#ffffff;">{{ number_format($totalIncumbents) }}</div>
            <div style="font-size:11px; color:#bfdbfe; margin-top:2px;">Active Incumbents</div>
        </div>
        <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:12px 16px;">
            <div style="font-size:24px; font-weight:700; color:#ffffff;">{{ number_format($totalFTEs, 2) }}</div>
            <div style="font-size:11px; color:#bfdbfe; margin-top:2px;">Total FTEs</div>
        </div>
    </div>
</div>

{{-- Module navigation --}}
<div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <h2 class="text-xs font-semibold uppercase tracking-widest mb-4" style="color: #9ca3af;">Quick Access</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <a href="{{ route('positions.index') }}"
           class="group flex items-start gap-4 p-5 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition"
           style="text-decoration: none;">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 transition"
                 style="background: #dbeafe;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #2563eb;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Positions</h3>
                <div class="text-xs mt-1 leading-relaxed text-gray-500 dark:text-gray-400">Manage authorized positions, budgets, classification, and org structure.</div>
            </div>
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a href="{{ route('incumbents.index') }}"
           class="group flex items-start gap-4 p-5 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition"
           style="text-decoration: none;">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: #cffafe;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #0891b2;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Incumbents</h3>
                <div class="text-xs mt-1 leading-relaxed text-gray-500 dark:text-gray-400">Track employees, FTE assignments, compensation history, and position occupancy.</div>
            </div>
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a href="{{ route('reports.index') }}"
           class="group flex items-start gap-4 p-5 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition"
           style="text-decoration: none;">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: #d1fae5;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #059669;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Reports</h3>
                <div class="text-xs mt-1 leading-relaxed text-gray-500 dark:text-gray-400">Run position control reports with configurable columns, filters, and CSV export.</div>
            </div>
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

    </div>
</div>

{{-- About section --}}
<div class="px-6 lg:px-8 py-6 lg:py-8 bg-gray-50 dark:bg-gray-800">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #3b82f6;">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                What is Position Control?
            </h2>
            <div class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Position control separates the <strong class="text-gray-700 dark:text-gray-300">position</strong> from the <strong class="text-gray-700 dark:text-gray-300">person</strong>.
                Each authorized role exists as a defined position with its own budget, classification, and
                status &mdash; independent of who fills it. Incumbents are assigned to positions with an FTE weight,
                giving you precise visibility into workforce utilization versus authorized headcount.
            </div>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981;">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Key Capabilities
            </h2>
            <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-2">
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    Positions can hold multiple incumbents simultaneously
                </li>
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    Incumbents can span multiple positions with fractional FTEs
                </li>
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    Full history tracking for all incumbent assignments
                </li>
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    5-level configurable organizational hierarchy
                </li>
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    Budgeted vs. actual compensation and FTE analysis
                </li>
                <li class="flex items-center gap-2">
                    <span style="width:6px; height:6px; border-radius:50%; background:#3b82f6; flex-shrink:0; display:inline-block;"></span>
                    Dynamic report builder with CSV export
                </li>
            </ul>
        </div>

    </div>
</div>
