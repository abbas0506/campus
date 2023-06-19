@extends('layouts.hod')
@section('page-content')
<div class="flex flex-col justify-center items-center w-full h-full">
    <div class="flex flex-col items-center justify-center w-3/4">

        <h1 class="text-3xl text-blue-900">One Time Activity</h1>
        <p class="text-center mt-4">These are configuration related activities that you need to do only for once and ripe the fruit for a long. This is a type of data that does not change for a long period of time!</p>
        <div class="grid grid-cols-4 gap-5 mt-12">

            <a href="{{url('programs')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-award text-2xl"></i>
                <div class="mt-2">Programs</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('courses')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-book text-2xl"></i>
                <div class="mt-2">Courses</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('schemes')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-map-pin text-2xl"></i>
                <div class="mt-2">Schemes</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('teachers')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-group text-2xl"></i>
                <div class="mt-2">Teachers</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>

        </div>
    </div>


</div>


@endsection