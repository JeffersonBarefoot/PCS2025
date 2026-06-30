@extends('layouts.app')

@section('content')
    <h1>Reports</h1>
    <p>No reports are available for you at the moment.</p>
    <a href="{{ route('reports.create') }}" class="btn btn-primary">Create a Report</a>
@endsection
