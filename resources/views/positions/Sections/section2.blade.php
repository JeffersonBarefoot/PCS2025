
PosSection2<br>
<div class="row">
    <div class="col-md-6">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="30%">Full Time Equivalents</th>
                <th width="30%"></th>
                <th width="10%"></th>
                <th width="10%"></th>
                <th width="40%"></th>
            </tr>
            </thead>

            <tr>
                <td>Annual FTE Basis</td>
                <td><input type="text" class="form-control" name="annftehour" id="annftehour"
                           value="{{$position->annftehour}}"
                           onChange="updateBudgetValues()" {{$readonly}}></td>
                <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip"
                          data-placement="top"
                          title="The number of hours per year that would be considered one FTE.  The most common value for this field is 2080, which is 40 hours per week x 52 weeks per year.  For most organizations, every position will have '2080' here."
                    ></span></td>

            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th width="30%">Costs</th>
                <th width="30%"></th>
                <th width="10%"></th>
                <th width="10%"></th>
                <th width="40%"></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-condensed">
            <tr>
                <td width="30%">FTE Calculation Frequency</td>
                <td width="30%"><input type="text" class="form-control" name="ftefreq" id="ftefreq"
                                       value="{{$position->ftefreq}}"
                                       onChange="updateBudgetValues()" {{$readonly}}></td>
                <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip"
                          data-placement="top"
                          title="The frequency that, when combined with the FTE Hours field, calculates the number of hours that this position is expected to work.  Example:  40 hours per week (full time), or 20 hours a month (part time).
                      Options are W(eekly), B(iweekly - every other week), S(emi-Monthly, twice a month), M(onthly), or A(nnually)."
                    ></span></td>

            </tr>

            <tr>
                <td>FTE Hours</td>
                <td><input type="text" class="form-control" id="ftehours" name="ftehours"
                           value="{{round($position->ftehours,3)}}"
                           onChange="updateBudgetValues()" {{$readonly}}></td>
                <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip"
                          data-placement="top"
                          title="The dollar amount that, when combined with the FTE Calculation Frequency field, calculates the number of hours that this position is expected to work.  Example:  40 hours per week (full time), or 20 hours a month (part time)."
                    ></span></td>
            </tr>

            <tr>
                <td>FTEs for this position</td>
                <td><input type="text" class="form-control" id="fulltimeequiv" name="fulltimeequiv"
                           value="{{round($position->fulltimeequiv,3)}}" readonly></td>
                <td></td>
                <td><img src="/images/ArrowRight.jpg" width="50" height="15"></td>

            </tr>
        </table>
    </div>

    <!-- *************************** -->
    <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
    <div class="col-md-6">
        <table class="table table-condensed">
            <tr>
                <td width="30%">Pay Frequency</td>
                <td width="30%"><input type="text" class="form-control" id="payfreq" name="payfreq"
                                       value="{{$position->payfreq}}"
                                       onChange="updateBudgetValues()" {{$readonly}}></td>
                <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip"
                          data-placement="top"
                          title="The frequency that, when combined with the budgeted pay rate, calculates the annual cost of ONE FULL TIME incumbent in this position.  Example:  $19.00 per hour, or $58,000 annually.
                        Options are H(ourly), W(eekly), B(iweekly - every other week), S(emi-Monthly, twice a month), M(onthly), or A(nnually)."
                    ></span></td>
                <td width="10%"></td>
                <td width="40%"></td>
            </tr>
            <!-- <tr>
              <td>Pay Frequency</td>
              <td></td>
              <td></td>
            </tr> -->
            <tr>
                <td>x Budgeted Pay Rate</td>
                <td><input type="text" class="form-control" id="payrate" name="payrate"
                           value="{{FormatDollars($position->payrate)}}"
                           onChange="updateBudgetValues()" {{$readonly}}></td>
                <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip"
                          data-placement="top"
                          title="The dollar amount that, when combined with the Pay Frequency field, calculates the cost of ONE FULL TIME incumbent in this position.  Example:  Example:  $19.00 per hour, or $58,000 annually."
                    ></span></td>
            </tr>

            <tr>
                <td>x Budgeted FTEs</td>
                <td><input type="text" class="form-control" id="dummyfulltimeequiv"
                           name="dummyfulltimeequiv" value="{{round($position->fulltimeequiv,3)}}"
                           readonly></td>
                <td></td>
            </tr>

            <tr>
                <td>= Budgeted Annual Cost</td>
                <td><input type="text" class="form-control" id="budgsal" name="budgsal"
                           value="{{FormatDollars($position->budgsal)}}" readonly></td>
                <td></td>
            </tr>


        </table>
    </div>
</div>
