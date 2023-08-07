@extends('layouts.hod')
@section('page-content')
<h1>Award Lists | Step 2</h1>
<p class="">{{$section->title()}}</p>
<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Click on any semester, courses will appear</li>
        <li>Click on print icon to print award lists of any course</li>
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

@php
$roman = config('global.romans');
@endphp
<!-- records found -->
<!-- <div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$section->course_allocations->count()}} courses found</div> -->

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

            <table class="table-auto w-full">
                <tbody>
                    @foreach($section->course_allocations()->during($semester->id)->has('first_attempts')->get() as $course_allocation)
                    <tr>
                        <td>{{$course_allocation->course->code ?? ''}}</td>
                        <td>{{$course_allocation->course->name ?? ''}}</td>
                        <td>{{$course_allocation->teacher->name ?? ''}}</td>
                        <td>
                            <div class="flex items-center">
                                <a href="{{route('hod.award.export', $course_allocation)}}" target="_blank" class="mr-3">
                                    <i class="bi-file-earmark-excel text-teal-600"></i>
                                </a>
                                <a href="{{route('hod.award.pdf', $course_allocation)}}" target="_blank" class="">
                                    <i class="bi-file-earmark-pdf text-red-600"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

@endsection