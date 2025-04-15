<div class="row">
    <!-- *************************** -->
    <!-- "THIS POSITION REPORTS TO" -->
    <div class="col-md-5" style="border: 1px solid grey;">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width:1%></th>
                <th width:68%>Reports Directly To:</th>
                <th width:30%>


                    @if ($readonly == "")
                        <!-- Modal -->
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-info btn" data-toggle="modal"
                                data-target="#directReportingModal">Assign
                        </button>
                        <!-- This is the modal istself -->
                        <div class="modal fade" id="directReportingModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h2>Directly Reports To:</h2>
                                        <input type="text" id="myInput" onkeyup="myFunction()"
                                               placeholder="Search for Descr or #"
                                               title="Type in a name">
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                            <table id="myTable">
                                                <tr class="header">
                                                    <th style="width:60%;">Position Company //
                                                        Number // Description
                                                    </th>
                                                </tr>


                                                @foreach($reportsToSource as $RTS)
                                                    <!-- <tr><td>{{$RTS->posno}}  /  {{$RTS->descr}}</td></tr> -->
                                                    <tr>
                                                        <td>
                                                            <a href={{route('positions.show',$position->id)}}?reportsdirto={{$RTS->id}}> {{$RTS->company}}
                                                                // {{$RTS->posno}}
                                                                // {{$RTS->descr}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
        @endif


    </div>

    </th>
    <th width:1%></th>
    </tr>
    </thead>
    <tr>
        <td></td>
        <td>
            @if ($position->reptoposno=="")
                Not Assigned
            @else
                {{$position->reptocomp}} / {{$position->reptoposno}}, {{$position->reptodesc}}
            @endif
        </td>
        <td></td>
    </tr>
    </table>
</div>
<div class="col-md-1"></div>

<div class="col-md-5" style="border: 1px solid grey;">
    <table class="table table-condensed">
        <thead>
        <tr>
            <th width:1%></th>
            <th width:68%>Reports Indirectly To:</th>
            <th width:30%>


                @if ($readonly == "")
                    <!-- Modal -->
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn" data-toggle="modal"
                            data-target="#directReportingModal2">Assign
                    </button>
                    <!-- This is the modal istself -->
                    <div class="modal fade" id="directReportingModal2" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>

                                </div>
                                <div class="modal-body">
                                    <h2>Indirectly Reports to:</h2>
                                    <input type="text" id="myInput" onkeyup="myFunction()"
                                           placeholder="Search for Descr or #"
                                           title="Type in a name">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="myTable">
                                            <tr class="header">
                                                <th style="width:60%;">Name</th>
                                                <th style="width:40%;">Country</th>
                                            </tr>


                                            @foreach($reportsToSource as $RTS)
                                                <!-- <tr><td>{{$RTS->posno}}  /  {{$RTS->descr}}</td></tr> -->
                                                <tr>
                                                    <td>
                                                        <a href={{route('positions.show',$position->id)}}?reportsindirto={{$RTS->id}}> {{$RTS->company}}
                                                            // {{$RTS->posno}} // {{$RTS->descr}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
    @endif


</div>

</th>
<th width:1%></th>
</tr>
</thead>
<tr>
    <td></td>
    <td>
        @if ($position->reptopos2=="")
            Not Assigned
        @else
            {{$position->reptocom2}} / {{$position->reptopos2}}, {{$position->reptodesc2}}
        @endif
    </td>


    <td></td>
</tr>
</table>
</div>
<div class="col-md-1"></div>
</div>


<!-- *************************** -->
<!-- "divider section with lines" -->
<div class="row">
    <div class="col-md-5" align="center">
{{--        Unicode Arrows--}}
        <span style='font-size:70px;'>&uarr;</span>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5" align="left">
        <span style='font-size:70px;'>&#8663;</span>
    </div>
    <div class="col-md-1"></div>
</div>

<div class="row">
    <!-- *************************** -->
    <!-- "THIS POSITION" -->
    <div class="col-md-5" style="border: 1px solid grey;">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="1%"></th>
                <th width="98%">This Position</th>
                <th width="1%"></th>
            </tr>
            </thead>
            <tr>
                <td></td>
                <td>{{$position->company}} / {{$position->posno}}, {{$position->descr}}</td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-md-7" align="left">
{{--        <img src="/images/ArrowDottedUpUp.jpg" width="50" height="120">--}}
    </div>
</div>


<!-- *************************** -->
<!-- "divider section with lines" -->
<div class="row">
    <div class="col-md-5" align="center">
        <span style='font-size:70px;'>&uarr;</span>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5" align="left">
        <span style='font-size:70px;'>&#8662;</span>
    </div>
    <div class="col-md-1"></div>
</div>

<div class="row">
    <!-- *************************** -->
    <!-- "REPORTS TO THIS POSITION" -->
    <div class="col-md-5" style="border: 1px solid grey;">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="1%"></th>
                <th width="98%">Direct Reports</th>
                <th width="1%"></th>
            </tr>
            </thead>
            @if ($dirRepCount >= 1)
                @foreach($directReports as $dirrep)
                    <tr>
                        <td></td>
                        <td>{{$dirrep->company.'/'.$dirrep->posno.', '.$dirrep->descr}}</td>
                        <td></td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td></td>
                    <td>No direct reports</td>
                    <td></td>
                </tr>
            @endif

        </table>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5" style="border: 1px solid grey;">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="1%"></th>
                <th width="98%">Indirect Reports</th>
                <th width="1%"></th>
            </tr>
            </thead>
            @if ($indirRepCount >= 1)
                @foreach($indirectReports as $indirrep)
                    <tr>
                        <td></td>
                        <td>{{$indirrep->company.'/'.$indirrep->posno.', '.$indirrep->descr}}</td>
                        <td></td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td></td>
                    <td>No indirect reports</td>
                    <td></td>
                </tr>
            @endif

            <!-- <tr>
                    @foreach($indirectReports as $indirrep)
                <tr>
                    <td></td>
                    <td>{{$indirrep->company.'/'.$indirrep->posno.', '.$indirrep->descr}}</td>
                          <td></td>
                      </tr>

                        @endforeach
            </tr> -->
        </table>
    </div>
</div>
