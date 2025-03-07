<div class="row">
    <div class="col-md-6">

        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="25%">Most recent changes</th>
                <th width="25%"></th>
                <th width="0%"></th>
                <th width="25%"></th>
                <th width="25%"></th>
            </tr>
            </thead>
        </table>
        @if(is_null($position->historyreason))
            No changes on file
        @else
            {!! nl2br($position->historyreason) !!}
        @endif
        <br>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="15%">From</th>
                <th width="8%">Active</th>
                <th width="8%">Filled?</th>
                <th width="8%">Budg FTEs</th>
                <th width="19%">Budg Sal</th>
                <th width="1%"></th>
            </tr>
            </thead>
            @foreach($posHistRecs as $posHistRecs)
                <tr>
                    <!-- <td>{{$posHistRecs->trans_date}}</td> -->
                    @if (is_null($posHistRecs->historystart))
                        <td>
                            <a href={{route('positions.show',$position->id)}}?viewposhistid={{$posHistRecs->id}}>
                            {{'Unknown to '.date_format(date_create($posHistRecs->historyend),"m/d/y")}}
                        </td>
                    @else
                        <td>
                            <a href={{route('positions.show',$position->id)}}?viewposhistid={{$posHistRecs->id}}>
                            {{date_format(date_create($posHistRecs->historystart),"m/d/y").' to '.date_format(date_create($posHistRecs->historyend),"m/d/y")}}
                        </td>
                    @endif
                    <td>{{$posHistRecs->active}}</td>
                    <td>
                        @switch($posHistRecs->curstatus)
                            @case ('VACANT') Vacant
                            @break
                            @case ('PARTIALLY FILLED') Partially Filled
                            @break
                            @case ('FILLED') Filled
                            @break
                            @case ('OVERFILLED') Overfilled
                            @break
                        @endswitch
                    </td>
                    <td>{{round($posHistRecs->fulltimeequiv,3)}}</td>
                    <td>{{formatdollars($posHistRecs->budgsal)}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- *************************** -->
    <!-- Right div contains details of selected position history record -->
    <div class="col-md-6">
        @foreach($viewPositionHistoryDetails as $vphd)
            {{$vphd->company.'/'.$vphd->posno.' '.$vphd->descr}}
            &nbsp;&#11044;&nbsp;
            {{date_format(date_create($vphd->historystart),"m/d/y").' to '.date_format(date_create($vphd->historyend),"m/d/y")}}
            &nbsp;&#11044;&nbsp;
            {{'Annual cost '.FormatDollars($vphd->budgsal)}}

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th width="25%">Status</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                </thead>


                <tr>
                    <td><b>Settings</b></td>
                    <td></td>
                    <td></td>
                    <td><b>Reference Dates</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Active Status:</td>
                    <td>{{$vphd->active}}</td>
                    <td></td>
                    <td>Established:</td>
                    <td>{{$vphd->startdate}}</td>
                </tr>

                <tr>
                    <td>Allow Mult Incumbs:</td>
                    @if ($vphd->multincumb=="1")
                        <td>Y</td>
                    @else
                        <td>N</td>
                    @endif
                    <td></td>
                    <td>Available:</td>
                    <td>{{$vphd->avail_date}}</td>
                </tr>

                <tr>
                    <td>Position Funded:</td>
                    <td>{{$vphd->funded}}</td>
                    <td></td>
                    <td>End Date:</td>
                    <td>{{$vphd->enddate}}</td>
                </tr>

                <tr>
                    <td><b>Status Changes</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Last Vacant:</td>
                    <td>{{$vphd->last_vac}}</td>
                    <td style="white-space: nowrap;">@if ($vphd->curstatus=='VACANT')
                            *** Status:  Vacant
                        @endif</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Last Partially Filled:</td>
                    <td>{{$vphd->last_par}}</td>
                    <td style="white-space: nowrap;">@if ($vphd->curstatus=='PARTIALLY FILLED')
                            *** Status:  Partially Filled
                        @endif</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Last Filled:</td>
                    <td>{{$vphd->last_fil}}</td>
                    <td style="white-space: nowrap;">@if ($vphd->curstatus=='FILLED')
                            *** Status:  Filled
                        @endif  </td>

                </tr>

                <tr>
                    <td>Last Overfilled:</td>
                    <td>{{$vphd->last_ove}}</td>
                    <td style="white-space: nowrap;">@if ($vphd->curstatus=='OVERFILLED')
                            *** Status:  Overfilled
                        @endif</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th width="25%">Budget</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                </tr>
                </thead>

                <tr>
                    <td><b>Budgeted FTEs</b></td>
                    <td></td>
                    <td></td>
                    <td><b>Budgeted Cost</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>Annual FTE Basis</td>
                    <td>{{round($vphd->annftehour,3)}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>FTE Calc Freq</td>
                    <td>{{$vphd->ftefreq}}</td>
                    <td></td>
                    <td>Budg Pay Freq</td>
                    <td>{{$vphd->payfreq}}</td>
                </tr>

                <tr>
                    <td>FTE Hours</td>
                    <td>{{round($vphd->ftehours,3)}}</td>
                    <td></td>
                    <td>Budg Pay Rate</td>
                    <td>{{formatdollars($vphd->payrate)}}</td>
                </tr>

                <tr>
                    <td>FTEs for Position</td>
                    <td>{{round($vphd->fulltimeequiv,3)}}</td>
                    <td><img src="/images/ArrowRight.jpg" width="50" height="15">
                    </td>
                    <td>FTEs for Position</td>
                    <td>{{round($vphd->fulltimeequiv,3)}}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Budg Annual Cost</td>
                    <td>{{formatdollars($vphd->budgsal)}}</td>
                </tr>


                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th width="25%">Organization</th>
                        <th width="25%"></th>
                        <th width="0%"></th>
                        <th width="25%"></th>
                        <th width="25%"></th>
                    </tr>
                    </thead>

                    <tr>
                        <td>{{$level1Description}}</td>
                        <td>{{$vphd->level1}}</td>
                        <td width="10%">
                        <td width="10%">
                        <td width="10%">
                    </tr>

                    <tr>
                        <td>{{$level2Description}}</td>
                        <td>{{$vphd->level2}}</td>
                    </tr>

                    <tr>
                        <td>{{$level3Description}}</td>
                        <td>{{$vphd->level3}}</td>
                    </tr>

                    <tr>
                        <td>{{$level4Description}}</td>
                        <td>{{$vphd->level4}}</td>
                    </tr>

                    <tr>
                        <td>{{$level5Description}}</td>
                        <td>{{$vphd->level5}}</td>
                    </tr>

                </table>


                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th width="25%">Reports to</th>
                        <th width="25%"></th>
                        <th width="0%"></th>
                        <th width="25%"></th>
                        <th width="25%"></th>
                    </tr>
                    </thead>

                    <tr>
                        <td>Reports Directly to</td>
                        <td style="white-space: nowrap;">@if ($vphd->reptocomp=='')
                                Not Assigned
                            @else
                                {{$vphd->reptocomp}} / {{$vphd->reptoposno}}
                                / {{$vphd->reptodesc}}
                            @endif</td>
                    </tr>

                    <tr>
                        <td>Reports Indirectly to</td>
                        <td style="white-space: nowrap;">@if ($vphd->reptocom2=='')
                                Not Assigned
                            @else
                                {{$vphd->reptocom2}} / {{$vphd->reptopos2}}
                                / {{$vphd->reptodesc2}}
                            @endif</td>
                    </tr>
                </table>

                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th width="25%">Changes made</th>
                        <th width="25%"></th>
                        <th width="0%"></th>
                        <th width="25%"></th>
                        <th width="25%"></th>
                    </tr>
                    </thead>
                </table>
                {!! nl2br($vphd->historyreason) !!}
                @endforeach
            </table>


    </div>
</div>
