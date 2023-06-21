@extends('layouts.teacher')
@section('page-content')
<h1>My Courses</h1>

<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$course_allocations->count()}} courses found
    </div>
</div>
@if(session('success'))
<div class="flex alert-success items-center mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>

    {{session('success')}}
</div>
@endif

<div class="grid grid-cols-2 gap-4 mt-12 md:w-4/5 mx-auto">
    <!-- sort courses section wise -->
    @foreach($course_allocations as $course_allocation)
    <div class="card relative flex flex-col justify-between items-center border p-4 bg-slate-50">
        <div class="absolute right-0 top-0 bg-teal-200 px-2 py-0 text-sm">
            <i class="bx bx-group"></i>
            {{$course_allocation->first_attempts->count()+$course_allocation->reappears->count()}}
        </div>
        <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex flex-col justify-center items-center">
            <i class="bx bx-book bx-md mt-4 text-slate-600"></i>
            <div class="font-semibold text-teal-800 mt-4 w-full text-center">
                {{$course_allocation->course->name}}
            </div>
            <div class="text-xs mt-2 mb-6">{{$course_allocation->section->title()}}</div>
        </a>
        <div class="slide-up">
            <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex items-center justify-center bg-green-100 hover:bg-green-200 rounded-full px-1">
                Enroll
                <i class="bx bx-user-plus bx-xs ml-1"></i>
            </a>
            <a href="{{route('formative.edit', $course_allocation)}}" class="flex items-center justify-center bg-orange-100 hover:bg-orange-200 rounded-full px-1">
                Formative
                <i class="bx bx-pencil bx-xs ml-1"></i>
            </a>
            <a href="{{route('summative.edit', $course_allocation)}}" class="flex items-center justify-center bg-pink-100 hover:bg-pink-200 rounded-full px-1">
                Summative
                <i class="bx bx-pencil bx-xs ml-1"></i>
            </a>
        </div>
    </div>
    @endforeach

</div>


@endsection