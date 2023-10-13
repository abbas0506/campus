@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Enroll Re-Appear</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.courseplan.index')}}">Semester Plan</a>
        <div>/</div>
        <a href="{{route('hod.courseplan.edit', $course_allocation)}}">{{$course_allocation->course->name}}</a>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-col items-center justify-center border-slate-300 bg-slate-200 p-2 mt-16">
        <h2>{{$course_allocation->course->name}}</h2>
        <div class="text-sm">{{$course_allocation->section->title()}}</div>
    </div>

    <div class="flex flex-col justify-center items-center border p-5">

        <form action="{{route('hod.search.reappear.data')}}" method="post">
            @csrf
            <input type="text" name='rollno' class="search-indigo w-60" placeholder="Enter student's roll no.">
            <input type="hidden" name='course_allocation_id' value="{{$course_allocation->id}}">
            <button type='submit'><i class="bi bi-search"></i></button>
        </form>

        @if(session('student'))
        <!-- display student info and enroll  -->
        <h2 class="mt-4 text-center">{{ session('student')->name }}</h2>
        <h2 class="text-center">{{ session('student')->rollno }}</h2>
        <form id='action_form' action="{{route('hod.reappears.store')}}" method="post" class="flex flex-col justify-center items-center w-full " onsubmit="return validate(event)">
            @csrf
            <div class="flex justify-end">
                <input type="hidden" name="rollno" class="" value="{{session('student')->rollno}}">
                <input type="hidden" name='course_allocation_id' value="{{$course_allocation->id}}">
                <button type='submit' class="btn-red rounded mt-4">Enroll Now</button>
            </div>
        </form>
        @endif

    </div>


</div>
@endsection