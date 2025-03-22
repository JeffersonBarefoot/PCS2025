{{--Section 4<br>--}}
{{--<div class="panel-heading">--}}
{{--    <h4 class="panel-title">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-2">--}}
{{--                <a data-toggle="collapse" href="#collapseOrgLevels">Organization</a>--}}
{{--            </div>--}}

{{--            <div class="col-md-10">--}}
{{--                @if ($position->level1 != '')--}}
{{--                    {{$position->level1}}--}}
{{--                @endif--}}
{{--                @if ($position->level2 != '')--}}
{{--                    / {{$position->level2}}--}}
{{--                @endif--}}
{{--                @if ($position->level3 != '')--}}
{{--                    / {{$position->level3}}--}}
{{--                @endif--}}
{{--                @if ($position->level4 != '')--}}
{{--                    / {{$position->level4}}--}}
{{--                @endif--}}
{{--                @if ($position->level5 != '')--}}
{{--                    / {{$position->level5}}--}}
{{--                @endif--}}
{{--            </div>--}}
{{--    </h4>--}}
{{--</div>--}}

{{--<div id="collapseOrgLevels" class="panel-collapse collapse">--}}
{{--    <!-- <div class="panel-body">Full Time Equivalent Calculation -->--}}
{{--    <div class="panel-body">--}}
<body>
{{--        <?php $level1Description = sessionGet('level1Desc') ?>--}}
{{--        <?php $level2Description = sessionGet('level2Desc') ?>--}}
{{--        <?php $level3Description = sessionGet('level3Desc') ?>--}}
{{--        <?php $level4Description = sessionGet('level4Desc') ?>--}}
{{--        <?php $level5Description = sessionGet('level5Desc') ?>--}}
{{--                <?php $level1Description = "check me" ?>--}}
{{--                <?php $level2Description = "check me" ?>--}}
{{--                <?php $level3Description = "check me" ?>--}}
{{--                <?php $level4Description = "check me" ?>--}}
{{--                <?php $level5Description = "check me" ?>--}}

        <div class="row">
            <div class="col-md-6">
                <table class="table table-condensed">
                    <tr>
                        <td>{{$level1Description}}</td>
                        <td><input type="text" class="form-control" name="Level1"
                                   value="{{$position->level1}}" {{$readonly}}></td>
                        <td width="10%">
                        <td width="10%">
                        <td width="10%">
                    </tr>

                    <tr>
                        <td>{{$level2Description}}</td>
                        <td><input type="text" class="form-control" name="Level2"
                                   value="{{$position->level2}}" {{$readonly}}></td>
                    </tr>

                    <tr>
                        <td>{{$level3Description}}</td>
                        <td><input type="text" class="form-control" name="Level3"
                                   value="{{$position->level3}}" {{$readonly}}></td>
                    </tr>

                    <tr>
                        <td>{{$level4Description}}</td>
                        <td><input type="text" class="form-control" name="Level4"
                                   value="{{$position->level4}}" {{$readonly}}></td>
                    </tr>

                    <tr>
                        <td>{{$level5Description}}</td>
                        <td><input type="text" class="form-control" name="Level5"
                                   value="{{$position->level5}}" {{$readonly}}></td>
                    </tr>
                </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
            <div class="col-md-6">
                <table class="table table-condensed">
                    <tr>
                        <td width="35%"></td>
                        <td width="35%"></td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                    </tr>
                </table>
            </div>
        </div>
{{--    </div>--}}
{{--</div>--}}
</body>
