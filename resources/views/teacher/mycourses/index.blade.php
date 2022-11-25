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

<div class="flex flex-wrap mt-12">
    @foreach($sections as $section)
    <!-- sort courses section wise -->
    @foreach($teacher->course_allocations->where('section_id',$section->id) as $course_allocation)
    <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex flex-col w-1/3 p-5">
        <div class="flex flex-col bg-green-100 p-4 rounded">
            <div class="flex justify-center items-center text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div class="flex flex-col items-center mt-4">
                <div class="font-bold text-green-800 text-center mb-2">
                    {{$course_allocation->course->name}}
                </div>
                <h1 class="text-4xl text-center text-green-800">{{$course_allocation->results()->count()}}</h1>
            </div>

        </div>
        <div class="border mt-2 text-center p-4">
            <div class="text-indigo-800 text-sm italic">{{$section->title()}}</div>
        </div>
    </a>
    @endforeach

    @endforeach
</div>
</div>

@endsection