<!-- *************************** -->
<!-- Left div contains list of all incumbents -->
<div class="row">
    <div class="col-md-3">Incumbents that have been in this position
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:40%>Started</th>
                <th width:10%>Status</th>
                <th width:10%>FTE</th>
                <th width:40%>Name</th>
                <!-- <th width:15%></th>
                <th width:30%></th> -->
            </tr>
            </thead>

            <tr>
            @foreach($incumbentsinposition as $incumbent)
                <tr>
                    <td>{{$incumbent->posstart}}</td>
                    <td>{{$incumbent->active_pos}}</td>
                    <td>{{round($incumbent->fulltimeequiv,3)}}</td>
                    <td>
                        <a href={{route('positions.show',$position->id)}}?viewincid={{$incumbent->id}}>{{substr($incumbent->fname,0,1).' '.$incumbent->lname}}
                    </td>

                </tr>
                @endforeach
                </tr>

        </table>
    </div>

    <!-- *************************** -->
    <!-- Middle div contains list of all history records for the selected incumbent -->
    <div class="col-md-3">Records on file for
        @foreach($viewincumbent as $vi)
            {{$vi->fname.' '.$vi->lname}}
        @endforeach

        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:40%>Record Created</th>
                <th width:10%>Status</th>
                <th width:10%>FTE</th>
                <th width:40%>Ann Cost</th>
            </tr>
            </thead>
            <tr>
                @foreach($viewincumbent as $VI)
                    <td>
                        <a href={{route('positions.show',$position->id)}}?viewinchistid={{'CURRENT'.$VI->id}}>Cur
                            Status</a>
                    </td>
                    <td>{{$VI->active_pos}}</td>
                    <td>{{round($VI->fulltimeequiv,3)}}</td>
                    <td>{{FormatDollars($VI->ann_cost)}}</td>
                @endforeach
            </tr>
            <tr>
            @foreach($viewincumbent as $viewinc)
                @foreach($viewIncumbentHistory as $incHistory)
                    <tr>
                        <!-- <td><a href={{route('positions.show',$position->id)}}?viewincid={{$viewinc->id}}&viewinchistid={{$incHistory->id}}>{{$incHistory->posstart}}</td> -->
                        <td>
                            <a href={{route('positions.show',$position->id)}}?viewinchistid={{$incHistory->id}}>{{$incHistory->trans_date}}
                        </td>
                        <td>{{$incHistory->active_pos}}</td>
                        <td>{{round($incHistory->fulltimeequiv,3)}}</td>
                        <td>{{FormatDollars($incHistory->ann_cost)}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    </tr>


        </table>
    </div>

    <!-- *************************** -->
    <!-- Right div contains details of selected incumbent -->
    <div class="col-md-6">Details:
        @foreach($viewIncumbentDetails as $vd)
            {{$vd->fname.' '.$vd->lname.' @ '.$vd->trans_date.', annual cost '.FormatDollars($vd->ann_cost)}}
        @endforeach
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:25%>Status</th>
                <th width:25%></th>
                <th width:0%></th>
                <th width:25%></th>
                <th width:25%></th>
            </tr>
            </thead>
            @foreach($viewIncumbentDetails as $IncDet)

                <tr>
                    <td>Status in Pos:</td>
                    <td>{{$IncDet->active_pos}}</td>
                    <td></td>
                    <td>Employment Status:</td>
                    <td>{{$IncDet->active}}</td>
                </tr>

                <tr>
                    <td>Started in Pos:</td>
                    <td style="text-align:left">{{$IncDet->posstart}}</td>
                    <td></td>
                    <td>Ended in Pos:</td>
                    <td>{{$IncDet->posstop}}</td>
                </tr>

                <tr>
                    <td>Last Hire Date:</td>
                    <td>{{$IncDet->lasthire}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:25%>Budget</th>
                <th width:25%></th>
                <th width:0%></th>
                <th width:25%></th>
                <th width:25%></th>
            </tr>
            </thead>

            <tr>
                <td>Hourly Rate</td>
                <td>{{FormatMoney($IncDet->unitrate)}}</td>
                <td></td>
                <td>Annualized Rate</td>
                <td>{{FormatDollars($IncDet->annual)}}</td>
            </tr>

            <tr>
                <td>Pay Frequency</td>
                <td>{{$IncDet->payfreq}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>FTEs in this Pos:</td>
                <td>{{round($IncDet->fulltimeequiv,3)}}</td>
                <td></td>
                <td>Annual Cost</td>
                <td>{{FormatDollars($IncDet->ann_cost)}}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:25%>Organization</th>
                <th width:25%></th>
                <th width:0%></th>
                <th width:25%></th>
                <th width:25%></th>
            </tr>
            </thead>

            <tr>
                <td>Org Level 1</td>
                <td>{{$IncDet->level1}}</td>
                <td></td>
                <td>Org Level 4</td>
                <td>{{$IncDet->level4}}</td>
            </tr>

            <tr>
                <td>Org Level 2</td>
                <td>{{$IncDet->level2}}</td>
                <td></td>
                <td>Org Level 5</td>
                <td>{{$IncDet->level5}}</td>
            </tr>

            <tr>
                <td>Org Level 3</td>
                <td>{{$IncDet->level3}}</td>
                <td></td>
                <td>Primary Job</td>
                <td>{{$IncDet->jobtitle}}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:25%>Data Updates</th>
                <th width:25%></th>
                <th width:0%></th>
                <th width:25%></th>
                <th width:25%></th>
            </tr>
            </thead>

            <tr>
                <td>Update Effective:</td>
                <td>{{$IncDet->hrmsdate}}</td>
                <td></td>
                <td>Update Reason</td>
                <td>{{$IncDet->hrmsreas}}</td>
            </tr>

            <tr>
                <td>Update Actual Date</td>
                <td>{{$IncDet->trans_date}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>


        @endforeach
        </table>
    </div>
</div>

