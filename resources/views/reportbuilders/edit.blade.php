<!doctype html>
<html lang="en">

@include('Common.001head')

<body>
<div class="container-fluid">

    <div class="row">
        @include('Common.102appnavbar')
    </div>

    <div class="row">
        <div class="col-10 offset-2 p-3">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-baseline border-bottom mb-3 pb-1">
                <h5 class="mb-0 fw-bold">Edit Report</h5>
                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-outline-secondary btn-action">
                    ← Back to Report
                </a>
            </div>

            <form id="save-report-form" action="{{ route('reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ── Report Metadata ──────────────────────────────────── --}}
                <div class="card mb-3">
                    <div class="card-header fw-semibold">Report Settings</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-medium">Report Name</label>
                                <input type="text" name="descr" value="{{ $report->descr }}"
                                       class="form-control" required maxlength="75">
                            </div>
                            <div class="col-2">
                                <label class="form-label fw-medium">Type</label>
                                <input type="text" value="{{ $report->group1 }}"
                                       class="form-control" readonly style="background:#f8f9fa">
                            </div>
                            <div class="col-2">
                                <label class="form-label fw-medium">Visibility</label>
                                <select name="private" class="form-select">
                                    <option value="N" {{ $report->private === 'N' ? 'selected' : '' }}>Team</option>
                                    <option value="Y" {{ $report->private === 'Y' ? 'selected' : '' }}>Private (only me)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Notes / Description</label>
                                <input type="text" name="notes" value="{{ $report->notes }}"
                                       class="form-control" maxlength="250"
                                       placeholder="Optional description shown to users">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Column Editor ────────────────────────────────────── --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Columns</span>
                        <span class="text-muted small">Drag rows or use ▲▼ to reorder</span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0" id="col-editor-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:4rem"></th>
                                    <th>Source Field</th>
                                    <th style="width:200px">Display Header</th>
                                    <th class="text-center" style="width:60px" title="Hide column from report output">Hide</th>
                                    <th class="text-center" style="width:70px" title="Default sort priority (1=first, 2=second, 0=none)">Sort</th>
                                    <th class="text-center" style="width:70px" title="Group rows by this column (1=primary group, 0=none)">Group</th>
                                    <th class="text-center" style="width:70px" title="Show subtotal per group">Sub</th>
                                    <th class="text-center" style="width:70px" title="Show grand total">Total</th>
                                </tr>
                            </thead>
                            <tbody id="col-tbody">
                                @foreach($columns as $col)
                                    <tr class="{{ $col->hidden === 'Y' ? 'table-secondary text-muted' : '' }}">
                                        {{-- Hidden order field --}}
                                        <input type="hidden" name="columns[{{ $col->id }}][id]" value="{{ $col->id }}">
                                        <input type="hidden" name="columns[{{ $col->id }}][columnorder]"
                                               class="col-order" value="{{ $col->columnorder }}">

                                        {{-- Move buttons --}}
                                        <td class="text-center" style="vertical-align:middle">
                                            <button type="button" class="btn btn-sm btn-action p-0 px-1 border-0"
                                                    onclick="moveColRow(this,'up')" title="Move up">▲</button>
                                            <button type="button" class="btn btn-sm btn-action p-0 px-1 border-0"
                                                    onclick="moveColRow(this,'down')" title="Move down">▼</button>
                                        </td>

                                        {{-- Source field (read-only) --}}
                                        <td class="small text-muted" style="vertical-align:middle">
                                            {{ $col->table }}.{{ $col->field }}
                                            @if($col->format)<span class="badge bg-secondary ms-1">{{ $col->format }}</span>@endif
                                        </td>

                                        {{-- Display header --}}
                                        <td>
                                            <input type="text"
                                                   name="columns[{{ $col->id }}][header]"
                                                   value="{{ $col->header }}"
                                                   class="form-control form-control-sm"
                                                   maxlength="100">
                                        </td>

                                        {{-- Hidden --}}
                                        <td class="text-center" style="vertical-align:middle">
                                            <input type="checkbox"
                                                   name="columns[{{ $col->id }}][hidden]"
                                                   value="Y"
                                                   class="form-check-input hide-toggle"
                                                   {{ $col->hidden === 'Y' ? 'checked' : '' }}>
                                        </td>

                                        {{-- Sort order --}}
                                        <td>
                                            <input type="number"
                                                   name="columns[{{ $col->id }}][sortorder]"
                                                   value="{{ $col->sortorder }}"
                                                   class="form-control form-control-sm text-center"
                                                   min="0" max="99">
                                        </td>

                                        {{-- Group order --}}
                                        <td>
                                            <input type="number"
                                                   name="columns[{{ $col->id }}][grouporder]"
                                                   value="{{ $col->grouporder }}"
                                                   class="form-control form-control-sm text-center"
                                                   min="0" max="99">
                                        </td>

                                        {{-- Subtotal --}}
                                        <td class="text-center" style="vertical-align:middle">
                                            <input type="checkbox"
                                                   name="columns[{{ $col->id }}][subtotal]"
                                                   value="Y"
                                                   class="form-check-input"
                                                   {{ $col->subtotal === 'Y' ? 'checked' : '' }}>
                                        </td>

                                        {{-- Total --}}
                                        <td class="text-center" style="vertical-align:middle">
                                            <input type="checkbox"
                                                   name="columns[{{ $col->id }}][total]"
                                                   value="Y"
                                                   class="form-check-input"
                                                   {{ $col->total === 'Y' ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ── Available Columns ───────────────────────────────────── --}}
                @if(!empty($availableColumns))
                @php
                    $groupedAvailable = collect($availableColumns)->groupBy(fn($c) => $c[0]);
                @endphp
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Add Columns</span>
                        <span class="text-muted small">Check columns to append to the report, then Save</span>
                    </div>
                    <div class="card-body">
                        @foreach($groupedAvailable as $tableName => $cols)
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-secondary">{{ $tableName }}</span>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none"
                                            onclick="toggleGroup('{{ $tableName }}', true)">select all</button>
                                    <span class="text-muted small">|</span>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none"
                                            onclick="toggleGroup('{{ $tableName }}', false)">clear</button>
                                </div>
                                <div class="row row-cols-2 row-cols-md-4 g-1">
                                    @foreach($cols as $col)
                                    @php $cbId = 'add_' . $col[0] . '_' . $col[1]; @endphp
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input add-col-cb"
                                                   type="checkbox"
                                                   name="add_columns[]"
                                                   value="{{ $col[0] }}.{{ $col[1] }}"
                                                   id="{{ $cbId }}"
                                                   data-tbl="{{ $tableName }}">
                                            <label class="form-check-label small" for="{{ $cbId }}">
                                                <span class="text-muted" style="font-size:0.7rem">{{ $col[1] }}</span><br>
                                                <em class="text-dark" style="font-size:0.75rem">{{ $col[2] }}</em>
                                                @if($col[3])<span class="badge bg-light text-secondary ms-1" style="font-size:0.6rem">{{ $col[3] }}</span>@endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </form>{{-- #save-report-form --}}

            {{-- ── Action Buttons (outside both forms to avoid nesting) ────── --}}
            <div class="d-flex gap-2 mt-2">
                <button type="submit" form="save-report-form"
                        class="btn btn-success btn-action px-4">
                    &#10003; Save Report
                </button>
                <a href="{{ route('reports.show', $report->id) }}"
                   class="btn btn-outline-secondary btn-action px-3">
                    Cancel
                </a>
                <div class="ms-auto">
                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                          onsubmit="return confirm('Delete this report? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-action px-3">
                            &#128465; Delete Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@include('Common.002script')

<script>
function moveColRow(btn, dir) {
    const row   = btn.closest('tr');
    const tbody = row.parentNode;
    if (dir === 'up' && row.previousElementSibling) {
        tbody.insertBefore(row, row.previousElementSibling);
    } else if (dir === 'down' && row.nextElementSibling) {
        tbody.insertBefore(row.nextElementSibling, row);
    }
    // Renumber the hidden columnorder inputs to reflect new positions
    tbody.querySelectorAll('.col-order').forEach((inp, i) => {
        inp.value = (i + 1) * 10;
    });
    // Dim hidden rows
    tbody.querySelectorAll('tr').forEach(r => {
        const cb = r.querySelector('.hide-toggle');
        r.classList.toggle('table-secondary', cb && cb.checked);
        r.classList.toggle('text-muted',      cb && cb.checked);
    });
}

// Dim row when hidden checkbox changes
document.querySelectorAll('.hide-toggle').forEach(cb => {
    cb.addEventListener('change', () => {
        const row = cb.closest('tr');
        row.classList.toggle('table-secondary', cb.checked);
        row.classList.toggle('text-muted',      cb.checked);
    });
});

function toggleGroup(tableName, checked) {
    document.querySelectorAll(`.add-col-cb[data-tbl="${tableName}"]`)
        .forEach(cb => cb.checked = checked);
}
</script>

</body>
</html>
