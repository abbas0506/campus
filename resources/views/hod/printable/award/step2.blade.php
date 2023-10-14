@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Award List</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{url('hod/printable')}}">Print Options</a>
        <div>/</div>
        <div>Award</div>
        <div>/</div>
        <div>Print</div>
    </div>


    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle pr-2 text-2xl"></i>
        <ul class="text-sm text-slate-600">
            <li>You can download .xslx or .pdf versions of the awards lists. </li>
            <li>Here, only that courses is visibe whose result has been submitted by corresponding teacher. </li>
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

    <div class="flex flex-col accordion mt-12">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="">Semester {{$roman[$semester->id-$section->clas->first_semester_id]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="text-xs text-slate-600 bx bx-book ml-6"></span>
                    <span class="text-xs text-slate-600 ml-1">
                        {{$section->course_allocations()->has('first_attempts')->during($semester->id)->count()}}/{{$section->course_allocations()->during($semester->id)->count()}}
                    </span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="overflow-x-auto w-full">
                    <table class="table-fixed borderless w-full">
                        <thead>
                            <tr>
                                <th class="w-24">Code</th>
                                <th class="w-60 text-left">Course</th>
                                <th class="w-60 text-left">Teacher</th>
                                <th class="w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($section->course_allocations()->during($semester->id)->has('first_attempts')->get() as $course_allocation)
                            <tr>
                                <td class="text-center">{{$course_allocation->course->code }}</td>
                                <td>{{$course_allocation->course->name }}</td>
                                <td>{{$course_allocation->teacher->name }}</td>
                                <td class="text-center">
                                    <a href="{{route('hod.award.export', $course_allocation)}}" target="_blank" class="mr-2">
                                        <i class="bi-file-earmark-excel text-teal-600"></i>
                                    </a>
                                    <a href="{{route('hod.award.pdf', $course_allocation)}}" target="_blank" class="">
                                        <i class="bi-file-earmark-pdf text-red-600"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection