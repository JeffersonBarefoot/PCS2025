{{--<body>--}}
<div class="col" id="datanavbar">
<form action={{route('incumbents.show',$incumbent->id)}} method="get">
    <div class="row">
        <div class="col">


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
{{--                                <a data-toggle="collapse" href="#collapseRep01">Filter list to include:</a>--}}
                                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseRep01"
                                   role="button"
                                   aria-expanded="false" aria-controls="collapseExample">
                                    <div class="default-text">Filter List to Include:</div>
                                </a>
                            </div>
                        </div>
                    </h4>
                </div>
                <div id="collapseRep01" class="panel-collapse collapse">
                    <div class="panel-body">

                        <?php $posNavbarCompanyQuery=Session::get('posNavbarCompanyQuery') ?>
                        <?php $posNavbarEmpnoQuery=Session::get('posNavbarEmpnoQuery') ?>
                        <?php $posNavbarLnameQuery=Session::get('posNavbarLnameQuery') ?>
                        <?php $posNavbarLevel1Query=Session::get('posNavbarLevel1Query') ?>
                        <?php $posNavbarLevel2Query=Session::get('posNavbarLevel2Query') ?>
                        <?php $posNavbarLevel3Query=Session::get('posNavbarLevel3Query') ?>
                        <?php $posNavbarLevel4Query=Session::get('posNavbarLevel4Query') ?>
                        <?php $posNavbarLevel5Query=Session::get('posNavbarLevel5Query') ?>

                        <?php $posNavbarLevel1Desc=Session::get('level1Desc') ?>
                        <?php $posNavbarLevel2Desc=Session::get('level2Desc') ?>
                        <?php $posNavbarLevel3Desc=Session::get('level3Desc') ?>
                        <?php $posNavbarLevel4Desc=Session::get('level4Desc') ?>
                        <?php $posNavbarLevel5Desc=Session::get('level5Desc') ?>

                        <table class="table table-responsive">
{{--                            <col>--}}
{{--                            <col>--}}
                            <tr>
                                <td class="default-text">Companies starting with:</td>
                                <td><input type="text" class="text-input-box"  name="company" value={{ $posNavbarCompanyQuery }}></td>
                            </tr>

                            <tr>
                                <td class="default-text">Employee Numbers containing:</td>
                                <td><input type="text" class="text-input-box"  name="empno" value={{ $posNavbarEmpnoQuery }}></td>
                            </tr>

                            <tr>
                                <td class="default-text">Last Names containing:</td>
                                <td><input type="text" class="text-input-box"  name="lname" value={{ $posNavbarLnameQuery }}></td>
                            </tr>

                            <tr>
                                @if ( $posNavbarLevel1Desc <> "" )
                                    <td class="default-text">{{$posNavbarLevel1Desc}}s starting with:</td>
                                    <td><input type="text" class="text-input-box"  name="level1" value={{ $posNavbarLevel1Query }}></td>
                                @endif
                            </tr>

                            <tr>
                                @if ( $posNavbarLevel2Desc <> "" )
                                    <td class="default-text">{{$posNavbarLevel2Desc}}s starting with:</td>
                                    <td><input type="text" class="text-input-box"  name="level2" value={{ $posNavbarLevel2Query }}></td>
                                @endif
                            </tr>


                            <tr>
                                @if ( $posNavbarLevel3Desc <> "" )
                                    <td class="default-text">{{$posNavbarLevel3Desc}}s starting with:</td>
                                    <td><input type="text" class="text-input-box"  name="level3" value={{ $posNavbarLevel3Query }}></td>
                                @endif
                            </tr>

                            <tr>
                                @if ( $posNavbarLevel4Desc <> "" )
                                    <td class="default-text">{{$posNavbarLevel4Desc}}s starting with:</td>
                                    <td><input type="text" class="text-input-box"  name="level4" value={{ $posNavbarLevel4Query }}></td>
                                @endif
                            </tr>

                            <tr>
                                @if ( $posNavbarLevel5Desc <> "" )
                                    <td class="default-text">{{$posNavbarLevel5Desc}}s starting with:</td>
                                    <td><input type="text" class="text-input-box"  name="level5" value={{ $posNavbarLevel5Query }}></td>
                                @endif
                            </tr>
                        </table>

                        <!-- <input type="submit" name="submit" value="Submit (blank queries return all records)"> -->
                        <button type="submit" class="btn btn-secondary">
                            <div class="default-text">Submit (blank fields return all positions)</div>
                        </button>
                        <!-- <button type="reset" class="btn btn-primary btn-sm">Reset Queries</button> -->
    {{ csrf_field() }}

</form>
<br>


</div>
</div>
</div>


<table class="table table-condensed">
    <col width="3">
    <col width="80">
    <col width="80">
    <col width="200">
    @foreach($incumbentsnavbar as $incumbent)

        <tr>
            <td>
                @if ($incumbent->active=='T')<span class="glyphicon glyphicon-remove" style="color:grey" data-toggle="tooltip" title="Inactive"></span>@endif
            </td>
            <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->company}}</td>
            <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->empno}}</td>
            <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->lname}}, {{$incumbent->fname}}</td>
        </tr>

    @endforeach
</table>
</div>

<!-- <div class="col-xs-4"> -->
<div class="col-md-9">
    @yield('main')
</div>






</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</div>
{{--</body>--}}
