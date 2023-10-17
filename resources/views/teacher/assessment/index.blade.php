@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>Student Assessment </h2>
            <div class="bread-crumb">
                <a href="{{route('teacher.mycourses.index')}}">Cancel & Go Back</a>
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
        <h2 class='text-red-600'>Print Assessment / Result </h2>
        <a href="" target='_blank' class="btn-teal text-sm"><i class="bi-printer"></i></a>
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

    <div class="grid grid-cols-2 gap-4 md:w-4/5 mx-auto mt-12 p-8 border border-dashed border-slate-400">
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">1</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="" class="link font-semibold">Mark Attendance</a>
                <p class="text-xs text-slate-600">Only those students can appear in final exam whose attendance is above 50%</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">2</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.formative.edit', $course_allocation)}}" class="link font-semibold">Add Formative Assessment</a>
                <p class="text-xs text-slate-600">Less than 50% marks will be considered a failure case </p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">3</div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="{{route('teacher.summative.edit', $course_allocation)}}" class="link font-semibold">Add Summative Assessment</a>
                <p class="text-xs text-slate-600">Less than 50% marks will be considered a failure case</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="h-6 w-6 flex flex-shrink-0 items-center justify-center bg-teal-600 mt-1 text-white text-sm">
                <i class="bi-check-all"></i>
            </div>
            <div class="flex-grow ml-4 md:ml-8">
                <a href="" class="link font-semibold">Submit Final Result</a>
                <p class="text-xs text-slate-600">Please confirm data before final submission. Once submitted, it will not be editable.</p>
            </div>
        </div>

    </div>
</div>
@endsection