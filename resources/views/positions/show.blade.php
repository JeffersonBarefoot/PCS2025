<!DOCTYPE html>
<html lang="en">
<head>
    {{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">--}}
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
    {{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}

    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .appnavdiv {
            border: 5px outset #ff00e5;
            background-color: #83d609;
            text-align: center;
        }
    </style>
    <title></title>

</head>

<body>
{{--pt-5 = padding at top of 5 (large)--}}
    <div class="container-fluid">
        <div class="row">
            <div class="appnavdiv">
                @include('positions.sections.appnavbar')
            </div>
        </div>

        <div class="col-sm span-5">
{{--            <div class="container-fluid">--}}

                <div class="row">
                    <div class="col">
                        @include('positions.sections.datanavbar')
                    </div>
                </div>
{{--            </div>--}}
        </div>
    </div>
</body>
</html>








