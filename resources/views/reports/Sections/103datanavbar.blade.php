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
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection1"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Positions - Current
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection1">
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
        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Position History -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection2"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Positions - History
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection2">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                        @foreach($availablereportsPOSH as $rep)
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
        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Incumbents -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection3"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Incumbents - Current
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection3">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                        @foreach($availablereportsINC as $rep)
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
        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Incumbents - History -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection4"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Incumbents - History
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection4">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                        @foreach($availablereportsINCH as $rep)
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

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Budgets -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection5"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Budgets
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection5">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                        @foreach($availablereportsBUDG as $rep)
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
        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Vacancies -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection6"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Vacancies
                </a>
            </p>
            {{--                        <div class="collapse" id="PosSection4">--}}
            <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="RepNavSection6">
                <div class="card card-body">
                    <table class="table table-condensed">
                        <tr>
                        @foreach($availablereportsVAC as $rep)
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

    </div>

    <!-- <div class="col-xs-4"> -->
    <div class="col-md-9">
        {{--        @yield('main')--}}
    </div>
    </form>


</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>

