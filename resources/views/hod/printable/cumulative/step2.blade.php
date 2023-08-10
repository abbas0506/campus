@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Cumulative Sheet</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('hod/printable')}}">Print Options</a>
        <div>/</div>
        <div>Cumulative</div>
    </div>

    <!-- help -->
    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle pr-2 text-2xl"></i>
        <ul class="text-xs">
            <li>Click on any program, sections will appear</li>
            <li>Click on any section to see or print cumulative sheets of the section</li>
        </ul>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @php
    $roman = config('global.romans');
    @endphp


    <h1 class='text-red-600 mt-8'>{{$section->title()}} </h1>

    <!-- records found -->
    <div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$section->course_allocations->count()}} courses found</div>
    <div class="flex flex-col">
        @foreach($semesters as $semester)
        <div class="collapsible">
            <div class="head">
                <h2 class="">Semester {{$roman[$semester->id - $section->clas->first_semester_id]}}<span class="ml-6 text-xs text-slate-600"><span class="bx bx-book mr-2"></span>{{$section->course_allocations()->during($semester->id)->count()}}</span></h2>
                <i class="bx bx-chevron-down"></i>
            </div>
            <div class="body">
                <div class="overflow-x-auto w-full">
                    @foreach($section->course_allocations()->during($semester->id)->get() as $course_allocation)
                    <div class="flex items-center justify-between w-full mb-1">
                        <input type="checkbox" name='chk' value="{{$course_allocation->id}}" class="mr-2 w-4 h-4">
                        <div class="w-24 shrink-0 text-center">{{$course_allocation->course->code}}</div>
                        <div class="w-60 shrink-0">{{$course_allocation->course->name}}</div>
                        <div class="w-24 shrink-0 text-slate-600 font-thin">{{$course_allocation->course->course_type->name}}</div>
                        <div class="w-60 shrink-0 text-slate-600 font-thin"><i class="bx bx-user"></i> ({{$course_allocation->teacher->name ?? ''}})</div>
                    </div>
                    @endforeach

                </div>
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
</div>
@endsection