<div class="row">
    <div class="col-md-12" style="background-color:#aaa;">

        {{--        <!-- <form action={{route('reports.show',$report->id)}} method="get"> -->--}}

        <h2>Available Reports:</h2>

        <br>

        <!-- ************************** -->
        <!-- ************************** -->
        <!-- Columns -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection1"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Report Components:  Columns
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
        <!-- Queries -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection2"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Report Components:  Queries
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
        <!-- Reports -->
        <!-- ************************** -->
        <!-- ************************** -->
        <div class="row">
            <p>
                {{--                        ________________________________________<br>--}}
                {{--                        Section 4, Layout Row 11<br>--}}
                <a class="btn btn-secondary" data-bs-toggle="collapse" href="#RepNavSection3"
                   role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Report Definitions
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



    </div>
</div>

