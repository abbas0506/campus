@extends('layouts.hod')
@section('page-content')
<h1>Course Allocation | Step I</h1>
<div class="bread-crumb">Course Plan / Choose section</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Click on any program to show classes and their sections</li>
        <li>Click on any section to plan courses and assign teachers for current semester</li>
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
@if(session('success'))
<div class="flex alert-success items-center mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('success')}}
</div>
@endif
@if(session('error'))
<div class="flex items-center alert-danger mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('error')}}
</div>
@endif

<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$programs->count()}} programs found</div>

<!-- Programs and classes -->
<div class="flex flex-col accordion">
    @foreach($programs->sortBy('level') as $program)
    <div class="collapsible">
        <div class="head">
            <h2 class="flex items-center space-x-4">
                {{$program->name}}
                <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->count()}}</span>
                <span class="text-xs ml-4 font-thin">Sections:{{$program->sections()->count()}}</span>
                <div class="flex items-center space-x-1">
                    <span class="bx bx-user text-[12px] text-slate-500"></span>
                    <span class="text-xs font-thin">{{$program->students()->count()}}</span>
                </div>

            </h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">
            @foreach($program->clases as $clas)
            <div class="flex items-center w-full border-b py-1 space-x-4">
                <div class="flex items-center justify-between w-1/2 md:w-1/4">
                    <div class="text-sm">{{$clas->short()}}</div>
                    <div class="text-xs text-slate-400"><i class="bx bx-user"></i> ({{$clas->strength()}})</div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-10 gap-2">
                    @foreach($clas->sections as $section)
                    <a href="{{route('courseplan.show',$section)}}" class='flex justify-center items-center bg-teal-100 hover:bg-teal-600 hover:text-slate-100 text-sm w-14'>
                        {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @endforeach

</div>
@endsection