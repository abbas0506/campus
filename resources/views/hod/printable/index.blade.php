@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Print / Download</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Print Options</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-12">
        <div class="flex flex-col md:flex-row md:items-center gap-x-2">
            <i class="bi bi-info-circle px-2 text-2xl"></i>
            <ul class="text-sm">
                <li>Here you can print or get soft copy output of the results orginally entered by the resource persons / teachers of your departments only.</li>
                <li></li>
            </ul>
        </div>

        <div class="grid  grid-cols-1 md:grid-cols-2 gap-5 mt-12">

            <a href="{{route('hod.attendance-sheets.index',1)}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi bi-pass text-2xl"></i>
                <div class="mt-2">Attendance Sheet</div>
            </a>
            <a href="{{route('hod.award.index')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi bi-award text-2xl"></i>
                <div class="mt-2">Award Lists</div>
            </a>
            <a href="{{route('hod.gazette.index')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi-journal-check text-2xl" -></i>
                <div class="mt-2">Gazette</div>
            </a>
            <a href="{{route('hod.cumulative.index')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi-clipboard-check text-2xl"></i>
                <div class="mt-2">Cumulative</div>
            </a>
        </div>

    </div>
</div>
@endsection