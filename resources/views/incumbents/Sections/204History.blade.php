<?php $selectedPositionText = sessionGet('selectedincumbentposition') ?>

<div class="row">

    {{-- Left: Positions this incumbent has occupied --}}
    <div class="col-md-3">
        <strong>Positions {{ $incumbent->fname }} {{ $incumbent->lname }} has occupied:</strong>
        <table class="table table-condensed mt-2">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="60%">Position</th>
                    <th width="30%">Last Active</th>
                </tr>
            </thead>
            @foreach($viewPositionsOccupied as $VPO)
                <tr>
                    <td>
                        @if ($VPO->active_pos == 'I')
                            <span style="color:grey">&#10006;</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('incumbents.show', $incumbent->id) }}?reqcompany={{ $VPO->incumbentcompany }}&reqpositioncompany={{ $VPO->positioncompany }}&reqpositionposno={{ $VPO->positionposno }}">
                            {{ $VPO->descr }}
                        </a>
                    </td>
                    <td>{{ date_format(date_create($VPO->posstop), "M Y") }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- Middle: History records for the selected position --}}
    <div class="col-md-3">
        <strong>{{ $incumbent->fname }} {{ $incumbent->lname }} &bull; {{ $selectedPositionText }}</strong>
        <table class="table table-condensed mt-2">
            <thead>
                <tr>
                    <th width="40%">Effective</th>
                    <th width="20%">FTEs</th>
                    <th width="40%">Ann Cost</th>
                </tr>
            </thead>
            @foreach($viewIncumbentPositionHistory as $VIPH)
                <tr>
                    <td>
                        <a href="{{ route('incumbents.show', $incumbent->id) }}?reqincumbenthistoryid={{ $VIPH->incumbentid }}">
                            {{ date_format(date_create($VIPH->posstart), "m/y") }} to {{ date_format(date_create($VIPH->posstop), "m/y") }}
                        </a>
                    </td>
                    <td>{{ round($VIPH->fulltimeequiv, 3) }}</td>
                    <td>{{ FormatMoney($VIPH->ann_cost) }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- Right: Detail for the selected history record --}}
    <div class="col-md-6">
        @if (!empty($IncHistRec))
            @foreach($IncHistRec as $IHR)
                <strong>{{ $IHR->fname }} {{ $IHR->lname }} &bull; {{ $IHR->poscompany }} / {{ $IHR->posno }} / {{ $selectedPositionText }}</strong>
                <br>{{ date_format(date_create($IHR->posstart), "m/d/Y") }}

                <table class="table table-condensed mt-2">
                    <thead><tr><th colspan="4">Status</th></tr></thead>
                    <tr>
                        <td width="25%">Status in Pos:</td><td>{{ $IHR->active_pos }}</td>
                        <td width="25%">Employment Status:</td><td>{{ $IHR->active }}</td>
                    </tr>
                    <tr>
                        <td>Started in Pos:</td><td>{{ $IHR->posstart }}</td>
                        <td>Ended in Pos:</td><td>{{ $IHR->posstop }}</td>
                    </tr>
                    <tr>
                        <td>Last Hire Date:</td><td>{{ $IHR->lasthire }}</td>
                        <td></td><td></td>
                    </tr>
                </table>

                <table class="table table-condensed">
                    <thead><tr><th colspan="4">Budget</th></tr></thead>
                    <tr>
                        <td width="25%">Hourly Rate:</td><td>{{ FormatMoney($IHR->unitrate) }}</td>
                        <td width="25%">Annualized Rate:</td><td>{{ FormatDollars($IHR->annual) }}</td>
                    </tr>
                    <tr>
                        <td>Pay Frequency:</td><td>{{ $IHR->payfreq }}</td>
                        <td>FTEs:</td><td>{{ round($IHR->fulltimeequiv, 3) }}</td>
                    </tr>
                    <tr>
                        <td>Annual Cost:</td><td>{{ FormatDollars($IHR->ann_cost) }}</td>
                        <td></td><td></td>
                    </tr>
                </table>

                <table class="table table-condensed">
                    <thead><tr><th colspan="4">Organization</th></tr></thead>
                    <tr>
                        <td width="25%">Org Level 1:</td><td>{{ $IHR->level1 }}</td>
                        <td width="25%">Org Level 4:</td><td>{{ $IHR->level4 }}</td>
                    </tr>
                    <tr>
                        <td>Org Level 2:</td><td>{{ $IHR->level2 }}</td>
                        <td>Org Level 5:</td><td>{{ $IHR->level5 }}</td>
                    </tr>
                    <tr>
                        <td>Org Level 3:</td><td>{{ $IHR->level3 }}</td>
                        <td>Job Title:</td><td>{{ $IHR->jobtitle }}</td>
                    </tr>
                </table>

                <table class="table table-condensed">
                    <thead><tr><th colspan="4">Data Updates</th></tr></thead>
                    <tr>
                        <td width="25%">Update Effective:</td><td>{{ $IHR->hrmsdate }}</td>
                        <td width="25%">Update Reason:</td><td>{{ $IHR->hrmsreas }}</td>
                    </tr>
                    <tr>
                        <td>Update Actual Date:</td><td>{{ $IHR->trans_date }}</td>
                        <td></td><td></td>
                    </tr>
                </table>

            @endforeach
        @else
            <p class="text-muted">Select a history record on the left to view details.</p>
        @endif
    </div>

</div>
