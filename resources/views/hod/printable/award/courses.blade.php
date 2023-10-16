@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Award List</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.award.index')}}">Cancel & Go Back</a>
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
    $semester=App\Models\Semester::find(session('semester_id'));
    $roman = config('global.romans');
    @endphp

    <h2 class="flex items-center mt-8">
        Semester {{$roman[$semester->id-$section->clas->first_semester_id+$section->clas->program->intake-1]}}
        <span class="text-sm text-slate-600"> &nbsp({{$semester->title()}})</span>
    </h2>
    <div class="overflow-x-auto w-full mt-1">
        <table class="table-fixed w-full">
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
                    <td>{{$course_allocation->course->code }}</td>
                    <td class="text-left">{{$course_allocation->course->name }}</td>
                    <td class="text-left">{{$course_allocation->teacher->name }}</td>
                    <td>
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
@endsection