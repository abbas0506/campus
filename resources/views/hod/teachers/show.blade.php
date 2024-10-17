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

        <div class="mt-8 p-8 shadow-lg bg-slate-100 rounded-lg">
            <h2 class="">{{ $teacher->name }}</h2>
            <p><i class="bi-house mr-2"></i>{{ $teacher->department->name }}</p>
            <p><i class="bi-telephone mr-2"></i>{{ $teacher->phone }}</p>
            <p><i class="bi-at mr-2"></i>{{ $teacher->email }}</p>

        </div>
        <div class="overflow-x-auto mt-4 w-full">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <td colspan="2">Current Allocations: {{$teacher->course_allocations()->shift(1)->sumOfCr()}}+{{$teacher->course_allocations()->shift(2)->sumOfCr()}}</td>
                    </tr>
                    <tr>
                        <th class="w-48">Morning</th>
                        <th class="w-48">Evenig</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr text-xs">
                        <td>
                            @foreach($teacher->course_allocations()->shift(1)->get() as $course_allocation )
                            <div class="text-xs text-left">{{$course_allocation->course->code}} <span class="text-slate-400">({{ $course_allocation->course->lblCr()}})</span>, {{$course_allocation->course->name}}</div>
                            <div class="text-xs"></div>
                            @endforeach
                        </td>
                        <td>
                            @foreach($teacher->course_allocations()->shift(2)->get() as $course_allocation )
                            <div class="text-xs text-left">{{$course_allocation->course->code}} <span class="text-slate-400">({{ $course_allocation->course->lblCr()}})</span>, {{$course_allocation->course->name}}</div>
                            <div class="text-xs"></div>
                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection