PosSection1 view<br>
<!-- ************************** -->
<!-- ************************** -->
<!-- Position Status -->
<!-- ************************** -->
<!-- ************************** -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-md-2">
                    <a href="#collapse1" data-toggle="collapse">Status</a>
                    <!-- <a class="btn btn-primary" onclick="expandStatus()" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1"> -->
                    <!-- Status
                  </a> -->
                </div>
                <div class="col-md-10">
                    Currently
                    @if ($position->active=="A")
                        Active,
                    @else
                        Inactive,
                    @endif
                    {{ ucwords(strtolower($position->curstatus)) }}
                </div>
            </div>
        </h4>
    </div>

    <!-- To Collapse:   <div class="panel-collapse collapse" id="collapse1" >
    To keep open:  <div class="panel-collapse" id="collapse1" >   -->
    <!-- <div class='panel-collapse collapse' id='collapse1' > -->
    <div id="collapse1" div class="panel-collapse collapse">
        <div class="panel-body">
            <!-- *************************** -->
            <!-- Left div contains xxxxxxxxxxxxxxxxxxxxxx -->
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th width="35%">Settings</th>
                            <th width="5%"></th>
                            <th width="15%"></th>
                            <th width="15%"></th>
                            <th width="30%"></th>
                        </tr>
                        </thead>

                        <tr>
                            <td>Active Status</td>
                            <td></td>
                            <div class="radio">

                                @if ($position->active=="A")
                                    <td>
                                        <label><input type="radio" name="active" value="A"
                                                      checked>Active</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="active" value="I" {{$disabled}}>Inactive</label>
                                    </td>
                                @else
                                    <td>
                                        <label><input type="radio" name="active" value="A" {{$disabled}}>Active</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="active" value="I"
                                                      checked>Inactive</label>
                                    </td>
                                @endif

                            </div>
                        </tr>

                        <tr>
                            <td>Allow Multiple Incumbents:</td>
                            <td></td>
                            <div class="radio">
                                @if ($position->multincumb==1)
                                    <td>
                                        <label><input type="radio" name="multincumb" value="1"
                                                      checked>Yes</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="multincumb" value="0" {{$disabled}}>No</label>
                                    </td>
                                @else
                                    <td>
                                        <label><input type="radio" name="multincumb" value="1" {{$disabled}}>Yes</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="multincumb" value="0"
                                                      checked>No</label>
                                    </td>
                                @endif

                            </div>
                        </tr>

                        <tr>
                            <td>Position Funded</td>
                            <td></td>
                            <div class="radio">

                                @if ($position->funded=="Y")
                                    <td>
                                        <label><input type="radio" name="funded" value="Y" checked>Yes</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="funded"
                                                      value="N" {{$disabled}}>No</label>
                                    </td>
                                @else
                                    <td>
                                        <label><input type="radio" name="funded"
                                                      value="Y" {{$disabled}}>Yes</label>
                                    </td>
                                    <td>
                                        <label><input type="radio" name="funded" value="N" checked>No</label>
                                    </td>
                                @endif
                            </div>
                        </tr>
                    </table>
                </div>

                <!-- *************************** -->
                <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th width="45%">Reference Dates</th>
                            <th width="10%"></th>
                            <th width="40%"></th>
                            <th width="4%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Established</td>
                            <td></td>
                            <td><input type="date" class="form-control" name="startdate"
                                       value="{{$position->startdate}}" {{$readonly}}></td>
                        </tr>
                        <tr>
                            <td>Available</td>
                            <td></td>
                            <td><input type="date" class="form-control" name="avail_date"
                                       value="{{$position->avail_date}}" {{$readonly}}></td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td></td>
                            <td><input type="date" class="form-control" name="enddate"
                                       value="{{$position->enddate}}" {{$readonly}}></td>
                        </tr>


                    </table>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th width="30%">Capacity Status</th>
                            <th width="30%"></th>
                            <th width="38%"></th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>

                        <tr>
                            <td>Last Became Vacant</td>
                            <td><input type="date" class="form-control" name="last_vac"
                                       value="{{$position->last_vac}}" {{$readonly}}></td>
                            <td>@if ($position->curstatus=='VACANT')
                                    *** Current Status:  Vacant
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Last Became Partially Filled</td>
                            <td><input type="date" class="form-control" name="last_par"
                                       value="{{$position->last_par}}" {{$readonly}}></td>
                            <!-- <td><input type="text" class="form-control" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td> -->
                            <td>@if ($position->curstatus=='PARTIALLYFILLED')
                                    *** Current Status:  Partially Filled
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Last Became Filled</td>
                            <td><input type="date" class="form-control" name="last_fil"
                                       value="{{$position->last_fil}}" {{$readonly}}></td>
                            <td>@if ($position->curstatus=='FILLED')
                                    *** Current Status:  Filled
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Last Became Overfilled</td>
                            <td><input type="date" class="form-control" name="last_ove"
                                       value="{{$position->last_ove}}" {{$readonly}}></td>
                            <td>@if ($position->curstatus=='OVERFILLED')
                                    *** Current Status:  Overfilled
                                @endif</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th width="45%">Vacancy Statistics</th>
                            <th width="10%"></th>
                            <th width="40%"></th>
                            <th width="4%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
