@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-8">My Courses</h1>

<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$teacher->course_allocations->count()}} courses found
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

<div class="flex flex-col mt-12 md:w-2/3 mx-auto">
    <!-- sort courses section wise -->
    @foreach($teacher->course_allocations as $course_allocation)
    <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex w-full border hover:bg-gray-100 my-4 p-4">

        <div class="flex flex-col justify-center text-green-800 px-5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
        </div>

        <div class="flex flex-col flex-1">
            <div class="font-bold text-green-800 mb-2">{{$course_allocation->course->name}}</div>
            <div class="text-sm">{{$course_allocation->section->title()}}</div>
        </div>
        <div class="flex flex-col items-center justify-center text-2xl text-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>

            {{$course_allocation->first_attempts->count()+ $course_allocation->reappears->count()}}
        </div>
    </a>
    @endforeach

</div>


@endsection