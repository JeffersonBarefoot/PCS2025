
<div class="row">
    <div class="col-md-12" style="background-color:#aaa;">

{{--        <!-- <form action={{route('reports.show',$report->id)}} method="get"> -->--}}

        <h2>Available Reports:</h2>

        <br>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Positions -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepSection1"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Positions
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepSection1">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                                                    @foreach($availablereportsPOS as $rep)
                                                        <tr>

                                                            <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>

                                                            <!-- <td>{{$rep->descr}}</td> -->

                                                        </tr>
                                                        @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep01">Positions - Current</a>
                        </div>
                    </div>
                </h4>
            </div>
            <div id="collapseRep01" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsPOS as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}

{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}

{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Position History -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep02">Positions - History</a>
                        </div>

                    </div>
                </h4>
            </div>
            <div id="collapseRep02" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsPOSH as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}
{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Incumbents -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep03">Incumbents - Current</a>
                        </div>

                    </div>
                </h4>
            </div>
            <div id="collapseRep03" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsINC as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}
{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Incumbents - History -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep04">Incumbents - History</a>
                        </div>

                    </div>
                </h4>
            </div>
            <div id="collapseRep04" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsINCH as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}
{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Budgets -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep05">Budgets</a>
                        </div>

                    </div>
                </h4>
            </div>
            <div id="collapseRep05" class="panel-collapse collapse">
                <div class="panel-body">Reserved for future functionality
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsBUDG as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}
{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Vacancies -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-md-12">
                            <a data-toggle="collapse" href="#collapseRep06">Vacancies</a>
                        </div>

                    </div>
                </h4>
            </div>
            <div id="collapseRep06" class="panel-collapse collapse">
                <div class="panel-body">Reserved for future functionality
                    <table class="table table-condensed">
                        <tr>
{{--                        @foreach($availablereportsVAC as $rep)--}}
{{--                            <tr>--}}

{{--                                <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>--}}
{{--                                <!-- <td>{{$rep->descr}}</td> -->--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
                            </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <!-- <div class="col-xs-4"> -->
    <div class="col-md-9">
{{--        @yield('main')--}}
    </div>
    </form>





</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>

