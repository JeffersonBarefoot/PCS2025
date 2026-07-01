@php
    // ── Column metadata maps ──────────────────────────────────────────────────
    $fmtMap      = [];
    $totalMap    = [];
    $subtotalMap = [];
    foreach ($availablereportcolumns as $rc) {
        $fmtMap[$rc->header]      = $rc->format  ?? '';
        $totalMap[$rc->header]    = $rc->total    ?? 'N';
        $subtotalMap[$rc->header] = $rc->subtotal ?? 'N';
    }

    // ── Grand total accumulators ──────────────────────────────────────────────
    $grandTotals = [];
    $hasTotals   = false;
    foreach ($totalMap as $hdr => $flag) {
        if ($flag === 'Y') { $grandTotals[$hdr] = 0; $hasTotals = true; }
    }
    $hasSubtotals = collect($subtotalMap)->contains('Y');

    // ── Grouping setup ────────────────────────────────────────────────────────
    $groupCols = collect($availablereportcolumns)
        ->filter(fn($rc) => ($rc->grouporder ?? 0) > 0)
        ->sortBy('grouporder')
        ->pluck('header')
        ->values()
        ->toArray();

    $isGrouped = !empty($groupCols);
    $grouped   = [];
    if ($isGrouped) {
        foreach ($reportarray as $row) {
            $arr = (array) $row;
            $key = implode(' › ', array_map(fn($gc) => $arr[$gc] ?? '(blank)', $groupCols));
            $grouped[$key][] = $row;
        }
    }

    // ── Formatting helpers ────────────────────────────────────────────────────
    $fmtVal = function($val, string $fmt) {
        if (is_null($val) || $val === '') return '';
        if (str_starts_with($fmt, 'R$')) return '$' . number_format((float) $val, 2);
        if (str_starts_with($fmt, 'R#')) return number_format((float) $val, 2);
        if ($fmt === 'DATE')             return $val ? date('m/d/Y', strtotime($val)) : '';
        return $val;
    };

    $alignCls = fn(string $fmt) =>
        (str_starts_with($fmt, 'R$') || str_starts_with($fmt, 'R#')) ? 'text-end' : '';

    // ── Sort URL builder ──────────────────────────────────────────────────────
    $sortUrl = function(string $col) use ($currentSort, $currentDir, $report) {
        $newDir = ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
        $params = array_merge(
            request()->except(['sort', 'dir', '_token']),
            ['sort' => $col, 'dir' => $newDir]
        );
        return route('reports.show', $report->id) . '?' . http_build_query($params);
    };
@endphp

@if(empty($reportarray))
    <p class="text-muted p-3 mb-0">No records match the current filters. Adjust parameters above and click <strong>Run Report</strong>.</p>
@else
    @php $cols = array_keys((array) $reportarray[0]); @endphp
    <div style="overflow-x: auto;">
        <table class="table table-sm table-striped table-bordered mb-0">

            {{-- ── Header row ─────────────────────────────────────────────── --}}
            <thead class="table-dark">
                <tr>
                    @if($isGrouped)<th style="width:2rem"></th>@endif
                    @foreach($cols as $col)
                        @php $fmt = $fmtMap[$col] ?? ''; @endphp
                        <th class="{{ $alignCls($fmt) }}" style="white-space:nowrap">
                            <a href="{{ $sortUrl($col) }}" class="text-white text-decoration-none">
                                {{ $col }}
                                @if($currentSort === $col)
                                    {!! $currentDir === 'asc' ? ' ▲' : ' ▼' !!}
                                @endif
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>

            @if($isGrouped)
                {{-- ── Grouped rendering ───────────────────────────────────── --}}
                @php $gi = 0; @endphp
                @foreach($grouped as $groupKey => $groupRows)
                    @php
                        $gi++;
                        $groupId = 'grp-' . $gi;
                        $grpSubs = [];
                        foreach ($subtotalMap as $h => $f) {
                            if ($f === 'Y') $grpSubs[$h] = 0;
                        }
                    @endphp

                    {{-- Group header --}}
                    <tbody>
                        <tr class="group-header table-primary fw-semibold"
                            style="cursor:pointer"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $groupId }}"
                            aria-expanded="true">
                            <td><span class="bi bi-chevron-down"></span></td>
                            <td colspan="{{ count($cols) }}">
                                {{ $groupKey }}
                                <span class="fw-normal text-muted small ms-2">({{ count($groupRows) }} records)</span>
                            </td>
                        </tr>
                    </tbody>

                    {{-- Collapsible data rows --}}
                    <tbody id="{{ $groupId }}" class="collapse show">
                        @foreach($groupRows as $row)
                            @php $rowArr = (array) $row; @endphp
                            <tr>
                                <td></td>
                                @foreach($cols as $col)
                                    @php
                                        $val = $rowArr[$col] ?? null;
                                        $fmt = $fmtMap[$col] ?? '';
                                        if (isset($grpSubs[$col]))      $grpSubs[$col]      += (float) $val;
                                        if (isset($grandTotals[$col]))  $grandTotals[$col]  += (float) $val;
                                    @endphp
                                    <td class="{{ $alignCls($fmt) }}">{{ $fmtVal($val, $fmt) }}</td>
                                @endforeach
                            </tr>
                        @endforeach

                        {{-- Per-group subtotal row --}}
                        @if($hasSubtotals && !empty($grpSubs))
                            <tr class="fw-bold table-warning">
                                <td></td>
                                @php $firstNonSub = true; @endphp
                                @foreach($cols as $col)
                                    @php $fmt = $fmtMap[$col] ?? ''; @endphp
                                    <td class="{{ $alignCls($fmt) }}">
                                        @if(isset($grpSubs[$col]))
                                            {{ $fmtVal($grpSubs[$col], $fmt) }}
                                        @elseif($firstNonSub)
                                            Subtotal
                                            @php $firstNonSub = false; @endphp
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endif
                    </tbody>
                @endforeach

            @else
                {{-- ── Flat rendering ─────────────────────────────────────── --}}
                <tbody>
                    @foreach($reportarray as $row)
                        @php $rowArr = (array) $row; @endphp
                        <tr>
                            @foreach($cols as $col)
                                @php
                                    $val = $rowArr[$col] ?? null;
                                    $fmt = $fmtMap[$col] ?? '';
                                    if (isset($grandTotals[$col])) $grandTotals[$col] += (float) $val;
                                @endphp
                                <td class="{{ $alignCls($fmt) }}">{{ $fmtVal($val, $fmt) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            @endif

            {{-- ── Footer: grand totals + record count ───────────────────── --}}
            <tfoot>
                @if($hasTotals)
                    <tr class="fw-bold table-secondary">
                        @if($isGrouped)<td></td>@endif
                        @php $firstNonTotal = true; @endphp
                        @foreach($cols as $col)
                            @php $fmt = $fmtMap[$col] ?? ''; @endphp
                            <td class="{{ $alignCls($fmt) }}">
                                @if(isset($grandTotals[$col]))
                                    {{ $fmtVal($grandTotals[$col], $fmt) }}
                                @elseif($firstNonTotal)
                                    Totals
                                    @php $firstNonTotal = false; @endphp
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endif
                <tr class="table-light">
                    <td colspan="{{ count($cols) + ($isGrouped ? 1 : 0) }}" class="text-muted small">
                        {{ count($reportarray) }} record(s)
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>
@endif
