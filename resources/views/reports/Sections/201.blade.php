<body>

<div class="panel-body">
    {{$report->notes}}<br>


    <table class="table table-condensed">
        <thead>
        <tr>
            <th width="20%">Field</th>
            <th width="10%">Start</th>
            <th width="5%"></th>
            <th width="10%">End</th>
            <th width="55%"></th>

        </tr>
        </thead>

        @foreach($reportqueries as $query)

                <?php $reportQueryBegKey = 'beg|' . $query->table . '||' . $query->field . '|||' . $query->datatype . '||||' ?>
                <?php $reportQueryEndKey = 'end|' . $query->table . '||' . $query->field . '|||' . $query->datatype . '||||' ?>



            <tr>

                <td>{{$query->descr}}</td>

                @if ($query->datatype=="DATE")
                    <!-- <td><input type="date" id=beg|{{$query->table}}||{{$query->field}}|||{{$query->datatype}}||||></td> -->
                    <td><input type="date"
                               id={{$reportQueryBegKey}} name={{$reportQueryBegKey}} value={{sessionGet($reportQueryBegKey)}}>
                    </td>
                @else
                    <!-- <td><input id=beg|{{$query->table}}||{{$query->field}}||| name=beg|{{$query->table}}||{{$query->field}}|||{{$query->datatype}}||||></td> -->
                    <td><input
                            id={{$reportQueryBegKey}} name={{$reportQueryBegKey}} value={{sessionGet($reportQueryBegKey)}}>
                    </td>
                @endif

                <td>to</td>

                @if ($query->datatype=="DATE")
                    <td><input type="date"
                               id={{$reportQueryEndKey}} name={{$reportQueryEndKey}} value={{sessionGet($reportQueryEndKey)}}>
                    </td>
                @else
                    <td><input
                            id={{$reportQueryEndKey}} name={{$reportQueryEndKey}} value={{sessionGet($reportQueryEndKey)}}>
                    </td>
                @endif

                <td>{{$query->options}}</td>
                <!-- <td>{{$query->table}}</td>
                <td>{{$query->field}}</td>
                <td>{{$query->datatype}}</td>
                <td>{{$query->descr}}</td> -->

            </tr>
        @endforeach
    </table>

    <button type="submit" class="btn btn-primary btn-sm">Run Report</button>
    <!-- <button type="reset" class="btn btn-primary btn-sm">Reset Queries</button> -->

</div>


</body>
