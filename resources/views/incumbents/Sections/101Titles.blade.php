<div class="row">
    <!-- <div class="col-sm-8 offset-sm-0"> -->
    {{--  @dump($dumprequest2)   --}}

    <div class="col-md-12">
        <h1 class="display-5">&nbsp;&nbsp;&nbsp;{{$incumbent->fname}}&nbsp{{$incumbent->lname}};<small>{{$incumbent->company}} / {{$incumbent->empno}}</small></h1>

        <!-- SAVE EDIT CHANGES -->
        <!-- Not working as of 2020-12-11 -->

        <br>
        <br>
        <button type="submit" class="btn btn-primary">Update</button>
        <br>
        <br>
    </div>
</div>
