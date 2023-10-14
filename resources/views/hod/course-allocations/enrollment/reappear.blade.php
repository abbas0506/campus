@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Enroll Re-Appearing Students</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.course-allocations.show',$course_allocation)}}">Cancel & Go Back</a>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="mt-8 border border-dashed p-4">
        <div class="flex items-center justify-center space-x-4 ">
            <h2 class='text-red-600'>{{$course_allocation->section->title()}}</h2>
            <p class="text-slate-600 text-sm">Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</p>
        </div>
        <h2 class="text-center mt-1">{{$course_allocation->course->name ?? ''}}</h2>
    </div>

    <div class="flex flex-col justify-center items-center border p-5 mt-4">

        <form action="{{route('hod.search.reappear.data')}}" method="post">
            @csrf
            <input type="text" name='rollno' class="search-indigo w-60" placeholder="Enter student's roll no.">
            <input type="hidden" name='course_allocation_id' value="{{$course_allocation->id}}">
            <button type='submit'><i class="bi bi-search"></i></button>
        </form>

        @if(session('student'))
        <!-- display student info and enroll  -->
        <h2 class="mt-4 text-center">{{ Str::upper(session('student')->name) }}</h2>
        <p class="text-center">{{ session('student')->rollno }}</p>
        <form id='action_form' action="{{route('hod.course-allocations.enrollment.reappear.post')}}" method="post" class="flex flex-col justify-center items-center w-full " onsubmit="return validate(event)">
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