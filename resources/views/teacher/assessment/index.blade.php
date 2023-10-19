@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>Student Assessment </h2>
            <div class="bread-crumb">
                <a href="{{route('teacher.mycourses.show',$course_allocation)}}">Cancel & Go Back</a>
            </div>
        </div>
        <div class="text-center">
            @if($course_allocation->submitted_at!='')
            <i class="bi-lock text-red-600 text-xl"></i>
            @else
            <i class="bi-unlock text-teal-600 text-xl"></i>
            @endif
            <div>Status</div>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-slate-600'>Preview Data</h2>
        <a href="{{route('teacher.assessment.preview', $course_allocation)}}" target="_blank" class="btn-teal text-sm"><i class="bi-eye"></i></a>
    </div>

    <div class="mt-8">
        <!-- search -->
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <div>{{$course_allocation->course->name}} </div>
                <h2>{{$course_allocation->section->title()}}</h2>
            </div>

            <div class="flex flex-wrap items-center space-x-4 mt-4 text-xs">
                <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                    <span class="bx bx-group text-sm rounded-full"></span>
                </div>
                <div>Fresh : {{$course_allocation->first_attempts->count()}}</div>
                <div class="mx-1 text-xs font-thin">|</div>
                <div>Re-Appear : {{$course_allocation->reappears->count()}}</div>
            </div>
        </div>
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @if($course_allocation->submitted_at)
    <div class="flex justify-center items-center mt-12 p-8 border border-dashed border-slate-200">
        <h2 class="text-red-700">Has been submitted on {{ $course_allocation->submitted_at ?? '' }} </h2>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-auto mt-12 p-8 border border-dashed border-slate-200">
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">1</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.attendance.edit',$course_allocation)}}" class="font-semibold text-blue-800">Mark Attendance</a>
                <p class="text-xs text-slate-600">Only those students can appear in final exam whose attendance is atleast 75%</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">2</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.formative.edit', $course_allocation)}}" class="font-semibold text-blue-800">Add Formative</a>
                <p class="text-xs text-slate-600">Less than 50% marks will be considered a failure case </p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">3</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.summative.edit', $course_allocation)}}" class="font-semibold text-blue-800">Add Summative</a>
                <p class="text-xs text-slate-600">Less than 50% marks will be considered a failure case</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">
                <i class="bi-check-all"></i>
            </div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.assessment.edit', $course_allocation)}}" class="font-semibold text-blue-800">Finish</a>
                <p class="text-xs text-slate-600">Once submitted, it will not be editable. Please preview & confirm data before final submission. </p>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection