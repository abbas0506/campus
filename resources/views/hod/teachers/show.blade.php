@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Teacher Profile</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.teachers.index')}}">Teachers</a>
        <div>/</div>
        <div>Profile</div>
    </div>

    <div class="w-full mx-auto">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="flex flex-wrap items-center space-x-4 mt-16">
            <h2 class="text-red-600">Total Allocations: {{$teacher->course_allocations()->count()}}</h2>
            <h2> <i class="bi-clock"></i> {{$teacher->course_allocations()->sumOfCr()}} </h2>
        </div>
        <div class="flex flex-col accordion mt-4">

            @foreach($shifts as $shift)
            <!-- dispaly shift only of it has some allocations -->
            @if($teacher->course_allocations()->shift($shift->id)->count())
            <div class="collapsible">
                <div class="head active">
                    <h2 class="flex items-center space-x-2 ">
                        {{$shift->name}}
                        <span class="text-xs ml-4 text-slate-600">{{$teacher->course_allocations()->shift($shift->id)->count()}}</span>
                        <span class="text-xs text-slate-600">({{$teacher->course_allocations()->shift($shift->id)->sumOfCr()}})</span>
                    </h2>
                    <i class="bx bx-chevron-down text-lg"></i>
                </div>
                <div class="body">
                    <div class="overflow-x-auto w-full">
                        <table class="table-fixed borderless w-full">
                            <thead>
                                <tr>
                                    <th class="w-8">#</th>
                                    <th class="w-24">Code</th>
                                    <th class="w-60 text-left">Course</th>
                                    <th class="w-48 text-left">Class</th>
                                    <th class="w-16">Fresh</th>
                                    <th class="w-16">Re</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($teacher->course_allocations()->shift($shift->id)->get() as $course_allocation)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">
                                        <a href="{{route('teacher.mycourses.show',$course_allocation->id)}}" class="link">
                                            {{$course_allocation->course->code}}
                                        </a>
                                    </td>
                                    <td class="text-left">{{$course_allocation->course->name}} <span class="text-slate-400 text-sm">{{$course_allocation->course->lblCr()}}</span> </td>
                                    <td class="text-left">{{$course_allocation->section->title()}}</td>
                                    <td>{{$course_allocation->first_attempts()->count()}}</td>
                                    <td>{{$course_allocation->reappears()->count()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>
</div>
@endsection