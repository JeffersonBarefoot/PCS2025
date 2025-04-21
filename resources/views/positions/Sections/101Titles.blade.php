{{--Pos Titles--}}
<!-- <div class="col-sm-8 offset-sm-0"> -->

<form action="{{ route('positions.update', $position->id) }}" method="POST">
    @csrf
    @method('PUT')

<div class="col-md-12">
    <h1 class="display-5">
        &nbsp;&nbsp;&nbsp;
        @if ($readonly=='readonly')
            {{$position->descr}}
        @else
            <input type="text" class="text-input-box" name="descr" value="{{$position->descr}}">
        @endif
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <small>{{$position->company}} / {{$position->posno}}</small>
    </h1>
    <a href={{route('positions.show',$position->id)}}?editmode=switch>{{Session::get('editModeButtonText')}}</a>
    {{--    This "submit" button triggers the form action, which is positions.update.  All other actions--}}
    {{--    (add new, delete, etc) call other forms to initiate or confirm the users intent--}}
    <button type="submit" class="styled-button">----------Save Changes          </button><br>
        <a href={{route('positions.create')}}>Add New Position </a><br>
        <a href={{ route('verifydestroy') }}?positiontodelete={{$position->id}}>Delete This Position </a><br>


</div>
