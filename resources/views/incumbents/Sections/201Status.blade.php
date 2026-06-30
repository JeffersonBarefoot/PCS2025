<div class="row">

    <div class="col-md-6">
        <table class="table table-condensed">
            <thead><tr><th colspan="2">Employment Status</th></tr></thead>
            <tr><td width="40%">Employment Active:</td><td>{{ $incumbent->active == 'A' ? 'Active' : 'Inactive' }}</td></tr>
            <tr><td>Position Status:</td><td>{{ $incumbent->active_pos == 'A' ? 'Active' : 'Inactive' }}</td></tr>
            <tr><td>Last Hire Date:</td><td>{{ $incumbent->lasthire }}</td></tr>
            <tr><td>Started in Position:</td><td>{{ $incumbent->posstart }}</td></tr>
            <tr><td>Ended in Position:</td><td>{{ $incumbent->posstop }}</td></tr>
            <tr><td>Reason:</td><td>{{ $incumbent->reason }}</td></tr>
        </table>

        <table class="table table-condensed">
            <thead><tr><th colspan="2">Compensation</th></tr></thead>
            <tr><td width="40%">Hourly Rate:</td><td>{{ FormatMoney($incumbent->unitrate) }}</td></tr>
            <tr><td>Annual Rate:</td><td>{{ FormatDollars($incumbent->annual) }}</td></tr>
            <tr><td>Pay Frequency:</td><td>{{ $incumbent->payfreq }}</td></tr>
            <tr><td>FTEs:</td><td>{{ round($incumbent->fulltimeequiv, 3) }}</td></tr>
            <tr><td>Annual Cost:</td><td>{{ FormatDollars($incumbent->ann_cost) }}</td></tr>
        </table>
    </div>

    <div class="col-md-6">
        <table class="table table-condensed">
            <thead><tr><th colspan="2">Organization</th></tr></thead>
            <tr><td width="40%">{{ $level1Description }}:</td><td>{{ $incumbent->level1 }}</td></tr>
            <tr><td>{{ $level2Description }}:</td><td>{{ $incumbent->level2 }}</td></tr>
            <tr><td>{{ $level3Description }}:</td><td>{{ $incumbent->level3 }}</td></tr>
            <tr><td>{{ $level4Description }}:</td><td>{{ $incumbent->level4 }}</td></tr>
            <tr><td>{{ $level5Description }}:</td><td>{{ $incumbent->level5 }}</td></tr>
            <tr><td>Job Code:</td><td>{{ $incumbent->jobcode }}</td></tr>
            <tr><td>Job Title:</td><td>{{ $incumbent->jobtitle }}</td></tr>
        </table>

        <table class="table table-condensed">
            <thead><tr><th colspan="2">Position</th></tr></thead>
            <tr><td width="40%">Company:</td><td>{{ $incumbent->poscompany }}</td></tr>
            <tr><td>Position #:</td><td>{{ $incumbent->posno }}</td></tr>
        </table>
    </div>

</div>
