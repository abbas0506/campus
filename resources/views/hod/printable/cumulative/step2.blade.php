@extends('layouts.hod')
@section('page-content')
<h1>Cumulative Sheet | Step 2</h1>
<p class="">{{$section->title()}}</p>
<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Click on any program, sections will appear</li>
        <li>Click on any section to see or print award lists of the section</li>
        <li></li>
    </ul>
</div>

@if ($errors->any())
<div class="alert-danger mt-8">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@php
$roman = config('global.romans');
@endphp

<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$section->course_allocations->count()}} courses found</div>

<div class="flex flex-col">
    @foreach($semesters as $semester)
    <div class="collapsible">
        <div class="head">
            <h2 class="">Semester {{$roman[$semester->id - $section->clas->semester_id]}}<span class="ml-6 text-xs text-slate-600"><span class="bx bx-book mr-2"></span>{{$section->course_allocations()->during($semester->id)->count()}}</span></h2>
            <i class="bx bx-chevron-down"></i>
        </div>
        <div class="body">
            @foreach($section->course_allocations()->during($semester->id)->get() as $course_allocation)

            <div class="flex items-center justify-between w-full mb-1">
                <input type="checkbox" name='chk' value="{{$course_allocation->id}}" class="mr-2">
                <div class="w-1/6">{{$course_allocation->course->code}}</div>
                <div class="w-1/3">{{$course_allocation->course->name}}</div>
                <div class="w-1/3 text-slate-600 font-thin">{{$course_allocation->course->course_type->name}}</div>
                <div class="w-1/3 text-slate-600 font-thin"><i class="bx bx-user"></i> ({{$course_allocation->teacher->name}})</div>
            </div>
            @endforeach
            <div class="w-full mt-2">
                <a href="{{route('hod.cum.preview', [$section->id,$semester->id])}}" class="flex items-center btn-teal text-sm float-left">
                    Print Cumulative Sheet
                    <i class="bi bi-printer ml-2"></i>
                </a>
            </div>

        </div>
    </div>

    @endforeach

</div>

@endsection