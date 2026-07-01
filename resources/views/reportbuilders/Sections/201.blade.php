<div>

    @foreach($reportqueries as $query)
        @php
            $begKey   = 'beg|' . $query->table . '||' . $query->field . '|||' . $query->datatype . '||||';
            $endKey   = 'end|' . $query->table . '||' . $query->field . '|||' . $query->datatype . '||||';
            $inputType = $query->datatype === 'DATE' ? 'date' : 'text';
        @endphp
        <div class="row g-2 align-items-center mb-1">
            <div class="col-3">
                <label class="col-form-label col-form-label-sm fw-medium">{{ $query->descr }}</label>
            </div>
            <div class="col-4">
                <input type="{{ $inputType }}"
                       id="{{ $begKey }}" name="{{ $begKey }}"
                       value="{{ sessionGet($begKey) }}"
                       class="form-control form-control-sm"
                       placeholder="From">
            </div>
            <div class="col-auto text-muted small">to</div>
            <div class="col-4">
                <input type="{{ $inputType }}"
                       id="{{ $endKey }}" name="{{ $endKey }}"
                       value="{{ sessionGet($endKey) }}"
                       class="form-control form-control-sm"
                       placeholder="To (optional)">
            </div>
        </div>
    @endforeach

    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-success btn-action px-4">
            &#9654; Run Report
        </button>
        <button type="submit" formaction="{{ route('reports.export', $report->id) }}"
                class="btn btn-outline-primary btn-action px-3">
            &#8595; Export CSV
        </button>
        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-outline-secondary btn-action px-3">
            &#10005; Clear Filters
        </a>
    </div>

</div>
