@extends('layouts.hod')
@section('page-content')
<div class="bg-teal-600">
    @foreach(Auth::user()->headships as $headship)
    department: {{$headship->department->name}}
    @endforeach
</div>
@endsection