{{--Pos Titles--}}
<!-- <div class="col-sm-8 offset-sm-0"> -->
<div class="col-md-12">
    <h1 class="display-5">
        &nbsp;&nbsp;&nbsp;
        @if ($readonly=='readonly')
            {{$incumbent->descr}}
        @else
            <input type="text" class="text-input-box" name="descr" value="{{$incumbent->descr}}">
        @endif
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <small>{{$incumbent->company}} / {{$incumbent->empno}}</small>
    </h1>
    <a href={{route('incumbents.show',$incumbent->id)}}?editmode=switch>{{Session::get('editModeButtonText')}}
        test</a><br>
    {{--    <a href={{route('positions.create')}}>Add New Position </a><br>--}}
    {{--    <a href={{ route('verifydestroy') }}?positiontodelete={{$position->id}}>Delete This Position </a><br>--}}
    {{--    <button type="Save Changes" class="btn btn-primary">Update</button>--}}

</div>
