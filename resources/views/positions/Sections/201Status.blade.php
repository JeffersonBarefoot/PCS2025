<div class="container-fluid">

    <div class="row">
        {{--        <div class="row">--}}
        <div class="col">
            {{--        <div class="container-fluid">--}}
            <table class="table">
                {{--        <div class="container-fluid">--}}
                {{--            <table class="table table-small">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th width: 35%>Settings</th>--}}
{{--                    <th width: 5%></th>--}}
{{--                    <th width: 15%></th>--}}
{{--                    <th width: 15%></th>--}}
{{--                    <th width: 30%></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
                <p></p-TableHeading>Status:</p>
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
        {{--        </div>--}}

        <!-- *************************** -->
        <!-- Right div contains  -->
        <div class="col">
            <table class="table">
                <p></p-TableHeading>Reference Dates:</p>
                <tr>
                    <td>Established</td>
                    <td></td>
                    <td><input type="date" class="text-input-box" name="startdate"
                               value="{{$position->startdate}}" {{$readonly}}></td>
                </tr>
                <tr>
                    <td>Available</td>
                    <td></td>
                    <td><input type="date" class="text-input-box" name="avail_date"
                               value="{{$position->avail_date}}" {{$readonly}}></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td></td>
                    <td><input type="date" class="text-input-box" name="enddate"
                               value="{{$position->enddate}}" {{$readonly}}></td>
                </tr>


            </table>
        </div>
        {{--        </div>--}}
    </div>


    <div class="row">
        <div class="col">
            <table class="table">
                <p></p-TableHeading>Position Last Became:</p>

                <tr>
                    <td>Vacant</td>
                    <td><input type="date" class="text-input-box" name="last_vac"
                               value="{{$position->last_vac}}" {{$readonly}}></td>
                    <td>@if ($position->curstatus=='VACANT')
                            *** Current Status:  Vacant
                        @endif</td>
                </tr>
                <tr>
                    <td>Partially Filled</td>
                    <td><input type="date" class="text-input-box" name="last_par"
                               value="{{$position->last_par}}" {{$readonly}}></td>
                    <!-- <td><input type="text" class="text-input-box" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td> -->
                    <td>@if ($position->curstatus=='PARTIALLYFILLED')
                            *** Current Status:  Partially Filled
                        @endif</td>
                </tr>
                <tr>
                    <td>Filled</td>
                    <td><input type="date" class="text-input-box" name="last_fil"
                               value="{{$position->last_fil}}" {{$readonly}}></td>
                    <td>@if ($position->curstatus=='FILLED')
                            *** Current Status:  Filled
                        @endif</td>
                </tr>
                <tr>
                    <td>Overfilled</td>
                    <td><input type="date" class="text-input-box" name="last_ove"
                               value="{{$position->last_ove}}" {{$readonly}}></td>
                    <td>@if ($position->curstatus=='OVERFILLED')
                            *** Current Status:  Overfilled
                        @endif</td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table">
                <p></p-TableHeading>Vacancy Statistics:</p>
            </table>
        </div>
    </div>
</div>

