@extends('layouts.admin')
@section('page-content')
<!-- <h1 class="mt-12">Departments</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$department->name}}
    </div>
</div> -->

<div class="container w-full mx-auto mt-8">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="text-xl text-teal-700">{{$department->name}}</div>

    @if($department->headship)
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <div class="text-sm text-slate-600 ml-2">{{$department->hod()->name}}</div>
        <div class="ml-3 text-xs text-green-800">(HoD)</div>
    </div>
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" />
        </svg>
        <div class="text-sm text-slate-600 ml-2">{{$department->hod()->email}}</div>
    </div>
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
        </svg>
        <div class="text-sm text-slate-600 ml-2">{{$department->hod()->phone}}</div>
    </div>
    @else
    <div class="text-sm text-red-600">HoD not assigned</div>
    @endif
    <div class="border-b py-4"></div>
    <div class="text-md font-bold mt-8">Programs <span class="text-xs">({{$department->programs->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->programs->sortBy('name') as $program)
        <div>&#9656; {{$program->short}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Courses <span class="text-xs">({{$department->courses->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->courses->sortBy('name') as $course)
        <div>&#9656; {{$course->short}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Teachers <span class="text-xs">({{$department->teachers()->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->teachers()->sortBy('name') as $teacher)
        <div>&#9656; {{$teacher->name}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Classes <span class="text-xs">({{$department->clases()->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->clases()->sortBy('name') as $clas)
        <div class="flex text-md">&#9656; {{$clas->short()}}
            &#8674;
            @foreach($clas->sections as $section)
            {{$section->name}}
            @endforeach
        </div>

        @endforeach
    </div>

</div>

@endsection