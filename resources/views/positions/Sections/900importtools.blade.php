{{--<head>--}}
<meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css"></script>

{{--    <style>--}}

{{--    </style>--}}

{{--</head>--}}

<div class="card card-default">
    <div class="card-header-heading">
        <h4 class="card-title">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseImport"
                       role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        Import Incumbent Files
                    </a>
                </div>

            </div>
        </h4>
    </div>
    <div class="collapse" id="collapseImport">
        <div class="card card-body">
            <div>
                <li>Import Incumbent Change file</li>
                <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <br/>
                    <input type="file" name="importFileName5" accept=".csv"/>
                    <br/>
                    <input type="submit" value=" Save "/>
                </form>
                <br/><br/>
            </div>
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseSetup"
                       role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        Initial Setup
                    </a>
                </div>

            </div>
        </h4>
    </div>
    <div id="collapseSetup" class="collapse">
        <div class="panel-body">


            <div>

                <h1>Import Files</h1>
                <ul>
                    <li>Initial Setup - Positions</li>
                    <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br/>
                        <input type="file" name="importFileName1" accept=".csv"/>
                        <br/>
                        <input type="submit" value=" Save "/>
                    </form>
                    <br/><br/>


                    <li>Initial Setup - Position history</li>
                    <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br/>
                        <input type="file" name="importFileName2" accept=".csv"/>
                        <br/>
                        <input type="submit" value=" Save "/>
                    </form>
                    <br/><br/>

                    <li>Initial Setup - Incumbents</li>
                    <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br/>
                        <input type="file" name="importFileName3" accept=".csv"/>
                        <br/>
                        <input type="submit" value=" Save "/>
                    </form>
                    <br/><br/>

                    <li>Initial Setup - Incumbent history</li>
                    <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br/>
                        <input type="file" name="importFileName4" accept=".csv"/>
                        <br/>
                        <input type="submit" value=" Save "/>
                    </form>
                    <br/><br/>

                </ul>
                <!-- https://blog.quickadminpanel.com/file-upload-in-laravel-the-ultimate-guide/ -->
                <!-- <form action={{ route('uploadfile') }} method="PUT" enctype="multipart/form-data"> -->

            </div>
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseUtilities"
                       role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        Utilities
                    </a>
                </div>

            </div>
        </h4>
    </div>
    <div id="collapseUtilities" class="collapse">
        <div class="card card-body">


            <div>
                <h1>Data Repair</h1>
                <ul>
                    <li>Add position descriptions to "Reports To" assignments</li>
                    <li>Replace sample data with new sample data (old sample data will be deleted)</li>
                    <li>Change position numbers</li>
                </ul>
            </div>
        </div>
    </div>
</div>



