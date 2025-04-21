<body>
Are you sure that you want to delete this position?
<br>
<br>
You cannot undo this.
<br>
<br>
{{$position->company}} / {{$position->posno}} / {{$position->descr}}
<br>
<br>
    <form action="{{ route('positions.destroy', $position->id)}}" method="post">
      @csrf
      @method('DELETE')
    <button type="submit" class="btn btn-primary">Delete</button>
</form>

<style>
  .uper {
    margin-top: 40px;
  }
</style>

</body>
