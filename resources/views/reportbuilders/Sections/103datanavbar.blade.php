<div class="col-md-12" style="background-color:#eee; padding:10px;">

    <h6 class="text-uppercase text-muted fw-bold mb-3">Report Library</h6>

    @php
        $navGroups = [
            'Position Reports'         => $availablereportsPOS,
            'Position History'         => $availablereportsPOSH,
            'Incumbent Reports'        => $availablereportsINC,
            'Incumbent History'        => $availablereportsINCH,
            'Budget Reports'           => $availablereportsBUDG,
            'Vacancy Reports'          => $availablereportsVAC,
            'Recruiting Reports'       => $availablereportsRECR,
        ];
        $navId = 0;
    @endphp

    @foreach($navGroups as $label => $groupReports)
        @if($groupReports->isNotEmpty())
            @php $navId++ @endphp
            <div class="mb-2">
                <a class="btn btn-sm btn-outline-secondary w-100 text-start"
                   data-bs-toggle="collapse"
                   href="#navGroup{{ $navId }}"
                   role="button">
                    {{ $label }}
                </a>
                <div class="collapse show" id="navGroup{{ $navId }}">
                    <ul class="list-unstyled ps-2 mt-1 mb-0">
                        @foreach($groupReports as $rep)
                            <li class="d-flex align-items-center gap-1">
                                <a href="{{ route('reports.show', $rep->id) }}"
                                   class="text-decoration-none small {{ isset($report) && $report->id == $rep->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                    {{ $rep->descr }}
                                    @if($rep->private === 'Y')
                                        <span class="text-muted" title="Private">&#128274;</span>
                                    @endif
                                </a>
                                @if(!$rep->is_system && $rep->userid === Auth::id())
                                    <a href="{{ route('reports.edit', $rep->id) }}"
                                       class="text-muted ms-auto" title="Edit report" style="font-size:0.7rem">
                                        <span class="bi bi-pencil-fill"></span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endforeach

</div>
