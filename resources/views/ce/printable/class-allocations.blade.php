@extends('layouts.controller')
@section('page-content')

<div class="container">
    <h1>Class Allocations</h1>
    <div class="bread-crumb">
        <a href="{{url('controller')}}">Home</a>
        <div>/</div>
        <div>Printable</div>
        <div>/</div>
        <div>{{$clas->title()}}</div>
        <div>/</div>
        <div>Allocations</div>
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif


    <div class="flex flex-col accordion mt-12">
        @foreach($clas->sections as $section)
        <div class="collapsible">
            <div class="head">
                <h2 class="w-full">
                    <span class="text-sm text-slate-600"> :: {{$section->name}}</span>
                    <span class="text-xs text-slate-600 bx bx-book ml-6"></span>
                    <span class="text-xs text-slate-600 ml-1">
                        {{$section->course_allocations()->during($semester_id)->count()}}
                    </span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">

                @foreach($section->course_allocations()->during($semester_id)->get() as $course_allocation)
                <div class="flex items-center w-full mb-1">
                    <div class="w-1/4">{{$course_allocation->course->code ?? ''}}</div>
                    <div class="w-1/3">{{$course_allocation->course->name ?? ''}}</div>
                    @if($course_allocation->teacher)
                    <div class="w-1/3 text-xs text-slate-400"><i class="bx bx-user"></i> ({{$course_allocation->teacher->name ?? ''}})</div>
                    <a href="{{route('ce.award.export', $course_allocation)}}" target="_blank" class="flex items-center">
                        <i class="bi-file-earmark-excel text-teal-600"></i>
                    </a>
                    <a href="{{route('ce.award.pdf', $course_allocation)}}" target="_blank" class="flex items-center">
                        <i class="bi-file-earmark-pdf text-red-600"></i>
                    </a>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection