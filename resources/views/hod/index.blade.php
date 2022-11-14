@extends('layouts.hod')
@section('page-content')
<div class="bg-teal-600">
    {{Auth::user()->teacher->department->name}}
</div>
@endsection