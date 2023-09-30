@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Course Allocation</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('courseplan')}}">Course Allocations</a>
        <div>/</div>
        <div>Step II</div>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @php
    $roman=config('global.romans');
    @endphp

    <h1 class='text-red-600 mt-8'>{{$section->title()}} </h1>
    <div class="flex flex-wrap items-center gap-4 mt-8">
        <p class="bg-teal-600 text-md font-semibold px-2 text-white">Scheme: {{$section->clas->scheme->title()}}</p>
        <p class="flex items-center bg-orange-100 px-2">
            <i class="bx bx-time-five"></i> <span class="font-semibold ml-2"></span>
        </p>
    </div>
    <div class="flex flex-col accordion mt-4">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id+$section->clas->program->intake-1]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="bx bx-time-five ml-6 text-slate-400"></span>
                    <span class="text-xs text-slate-600 ml-2"> / {{$section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->sum('cr') }}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="flex flex-col w-full even:bg-slate-100 py-1 text-xs overflow-x-auto">
                    <div class="flex w-full border-b text-xs font-semibold py-1">
                        <div class="w-16 shrink-0 text-center">Slot</div>
                        <div class="w-32 shrink-0">Course Type</div>
                        <div class="shrink-0 w-24">Code</div>
                        <div class="shrink-0 w-64">Course</div>
                        <div class="shrink-0 w-64">Teacher</div>
                    </div>

                    <div class="mt-1">
                        @php $prev_slot_no=''; @endphp
                        @foreach($section->course_allocations()->for($semester->id)->get() as $course_allocation)
                        <div class="flex w-full">
                            @if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                            <div class="shrink-0 w-16 text-center">{{$course_allocation->slot_option->slot->slot_no}}</div>
                            @else
                            <div class="shrink-0 w-16 text-center"></div>
                            @endif

                            @if($semester->id==session('semester_id'))
                            <a href="{{route('courseplan.edit',$course_allocation)}}" class="shrink-0 w-32 text-left link">{{$course_allocation->slot_option->course_type->name}}</a>
                            @else
                            <div class="shrink-0 w-32 text-left">{{$course_allocation->slot_option->course_type->name}}</div>
                            @endif
                            @if($course_allocation->course()->exists())
                            <div class="shrink-0 w-24">{{ $course_allocation->course->code }}</div>
                            <div class="shrink-0 w-64">{{ $course_allocation->course->name }}</div>
                            <div class="shrink-0 w-64">{{$course_allocation->teacher->name ?? ''}}</div>
                            @endif
                        </div>
                        @php

                        if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                        $prev_slot_no=$course_allocation->slot_option->slot->slot_no;
                        @endphp
                        @endforeach

                    </div>


                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection