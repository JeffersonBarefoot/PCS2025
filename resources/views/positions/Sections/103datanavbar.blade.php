<div class="col">
    <form action={{route('positions.show',$position->id)}} method="get">
        <div class="row">
            <div class="col">
                {{--                datanavdiv - 103datanavbar.blade.php--}}

                <!-- ************************** -->
                <!-- ************************** -->
                <!-- Query:  Find a position -->
                <!-- ************************** -->
                <!-- ************************** -->
                <div>
                    <br>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <a data-bs-toggle="collapse"
                                       aria-expanded="true"
                                       data-bs-target="#collapseFilter01"
                                       role="button"
                                       aria-controls="collapseExample">
                                        Filter list to include:
                                    </a>
                                </div>
                            </div>
                        </h4>
                    </div>
                    <div id="collapseFilter01" class="panel-collapse">
                        <div class="card card-body">

                            <?php $posNavbarCompanyQuery = Session::get('posNavbarCompanyQuery') ?>
                            <?php $posNavbarPosnoQuery = Session::get('posNavbarPosnoQuery') ?>
                            <?php $posNavbarDescrQuery = Session::get('posNavbarDescrQuery') ?>
                            <?php $posNavbarLevel1Query = Session::get('posNavbarLevel1Query') ?>
                            <?php $posNavbarLevel2Query = Session::get('posNavbarLevel2Query') ?>
                            <?php $posNavbarLevel3Query = Session::get('posNavbarLevel3Query') ?>
                            <?php $posNavbarLevel4Query = Session::get('posNavbarLevel4Query') ?>
                            <?php $posNavbarLevel5Query = Session::get('posNavbarLevel5Query') ?>

                            <?php $posNavbarLevel1Desc = Session::get('level1Desc') ?>
                            <?php $posNavbarLevel2Desc = Session::get('level2Desc') ?>
                            <?php $posNavbarLevel3Desc = Session::get('level3Desc') ?>
                            <?php $posNavbarLevel4Desc = Session::get('level4Desc') ?>
                            <?php $posNavbarLevel5Desc = Session::get('level5Desc') ?>

                            <table class="table table-condensed">
                                <col>
                                <col>
                                <tr>
                                    <td>Companies starting with:</td>
                                    <td><input type="text" class="form-control" style="font-size:11pt;"
                                               name="company" value={{ $posNavbarCompanyQuery }}></td>
                                </tr>

                                <tr>
                                    @if ( $posNavbarLevel1Desc <> "" )
                                        <td>{{$posNavbarLevel1Desc}}s starting with:</td>
                                        <td><input type="text" class="form-control" style="font-size:11pt;"
                                                   name="level1" value={{ $posNavbarLevel1Query }}></td>
                                    @endif
                                </tr>

                                <tr>
                                    @if ( $posNavbarLevel2Desc <> "" )
                                        <td>{{$posNavbarLevel2Desc}}s starting with:</td>
                                        <td><input type="text" class="form-control" style="font-size:11pt;"
                                                   name="level2" value={{ $posNavbarLevel2Query }}></td>
                                    @endif
                                </tr>


                                <tr>
                                    {{--                                            @dump('Level3')--}}
                                    @if ( $posNavbarLevel3Desc <> "" )
                                        <td>{{$posNavbarLevel3Desc}}s starting with:</td>
                                        <td><input type="text" class="form-control" style="font-size:11pt;"
                                                   name="level3" value={{ $posNavbarLevel3Query }}></td>
                                    @endif
                                </tr>

                                <tr>
                                    @if ( $posNavbarLevel4Desc <> "" )
                                        <td>{{$posNavbarLevel4Desc}}s starting with:</td>
                                        <td><input type="text" class="form-control" style="font-size:11pt;"
                                                   name="level4" value={{ $posNavbarLevel4Query }}></td>
                                    @endif
                                </tr>

                                <tr>
                                    @if ( $posNavbarLevel5Desc <> "" )
                                        <td>{{$posNavbarLevel5Desc}}s starting with:</td>
                                        <td><input type="text" class="form-control" style="font-size:11pt;"
                                                   name="level5" value={{ $posNavbarLevel5Query }}></td>
                                    @endif
                                </tr>

                                <tr>
                                    <td>Position Numbers starting with:</td>
                                    <td><input type="text" class="form-control" name="posno"
                                               value={{ $posNavbarPosnoQuery }}></td>
                                </tr>

                                <tr>
                                    <td>Descriptions containing:</td>
                                    <td><input type="text" class="form-control" name="descr"
                                               value={{ $posNavbarDescrQuery }}></td>
                                </tr>


                            </table>

                            <!-- <input type="submit" name="submit" value="Submit (blank queries return all records)"> -->
                            <button type="submit" class="btn btn-primary btn-sm">Submit (blank fields return
                                all positions)
                            </button>
                            <!-- <button type="reset" class="btn btn-primary btn-sm">Reset Queries</button> -->
                            {{ csrf_field() }}

                        </div>
                    </div>
                    <table class="table table-condensed">
                        <col width="3">
                        <col width="3">
                        <col width="80">
                        <col width="80">
                        <col width="200">
                        @foreach($positionsnavbar as $position)

                            <tr>
                                <td>
                                    @if ($position->active=='I')
                                        <i class="bi-x-circle-fill" style="color:black" data-toggle="tooltip"
                                           title="Inactive"></i>
                                    @endif
                                </td>

                                <td>
                                    @if ($position->curstatus=='VACANT')
                                        <i class="bi-square" style="color:lightgrey" data-toggle="tooltip"
                                           title="Vacant"></i>
                                    @endif
                                    @if ($position->curstatus=='PARTIALLY FILLED')
                                        <i class="bi-square-half" style="color:blue" data-toggle="tooltip"
                                           title="Partially Filled"></i>
                                    @endif
                                    @if ($position->curstatus=='FILLED')
                                        <i class="bi-square-fill" style="color:limegreen" data-toggle="tooltip"
                                           title="Filled"></i>
                                    @endif
                                    @if ($position->curstatus=='OVERFILLED')
                                        <i class="bi-triangle-fill" style="color:red" data-toggle="tooltip"
                                           title="Overfilled"></i>
                                    @endif
                                </td>

                                <td>
                                    @if ($position->curstatus=='VACANT')
                                        <i class="bi-cash-coin" style="color:lightgrey" data-toggle="tooltip"
                                           title="Vacant"></i>
                                    @endif
                                    @if ($position->curstatus=='PARTIALLY FILLED')
                                        <i class="bi-cash-coin" style="color:blue" data-toggle="tooltip"
                                           title="Partially Filled"></i>
                                    @endif
                                    @if ($position->curstatus=='FILLED')
                                        <i class="bi-cash-coin" style="color:limegreen" data-toggle="tooltip"
                                           title="Filled"></i>
                                    @endif
                                    @if ($position->curstatus=='OVERFILLED')
                                        <i class="bi-cash-coin" style="color:red" data-toggle="tooltip"
                                           title="Overfilled"></i>
                                    @endif
                                </td>

                                <td height="25"><a
                                        href={{route('positions.show',$position->id)}}>{{$position->company}}
                                </td>
                                <td height="25"><a
                                        href={{route('positions.show',$position->id)}}>{{$position->posno}}</td>
                                <td height="25"><a
                                        href={{route('positions.show',$position->id)}}>{{$position->descr}}</td>
                            </tr>

                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        {{--        </div>--}}
    </form>
</div>
{{--</body>--}}

