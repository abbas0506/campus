@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Cumulative Sheet | Preview</h1>
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

<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$section->course_allocations->count()}} courses found</div>

<div class="flex flex-col accordion">
    @foreach($semester_nos as $semester_no)
    <div class="collapsible">
        <div class="head">
            <h2 class="">Semester {{$semester_no}} </h2>
            <i class="bx bx-printer text-lg"></i>
        </div>
        <div class="body">
            @foreach($section->course_allocations->where('semester_no',$semester_no) as $course_allocation)
            <div class="flex items-center justify-between w-full mb-1">
                <div class="w-1/2">{{$course_allocation->course->name}}</div>
                <div class="w-1/3 text-xs text-slate-400"><i class="bx bx-user"></i> ({{$course_allocation->teacher->name}})</div>

            </div>

            @endforeach
        </div>
    </div>

    @endforeach

</div>

@endsection