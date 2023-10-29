@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>Finish Assessment </h2>
            <div class="bread-crumb">
                <a href="{{route('teacher.assessment.show',$course_allocation)}}">Cancel & Go Back</a>
            </div>
        </div>
        <div class="text-center">
            @if($course_allocation->submitted_at!='')
            <i class="bi-lock text-red-600 text-xl"></i>
            @else
            <i class="bi-unlock text-teal-600 text-xl"></i>
            @endif
            <div>Status</div>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-slate-600'>@if($course_allocation->submitted_at) Preview Data @else Proof Reading @endif</h2>
        <a href="{{route('teacher.assessment.preview', $course_allocation)}}" class="btn-teal text-sm"><i class="bi-eye"></i></a>
    </div>

    <div class="mt-8">
        <!-- search -->
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <div>{{$course_allocation->course->name}} </div>
                <h2>{{$course_allocation->section->title()}}</h2>
            </div>

            <div class="flex flex-wrap items-center space-x-4 mt-4 text-xs">
                <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                    <span class="bx bx-group text-sm rounded-full"></span>
                </div>
                <div>Fresh : {{$course_allocation->first_attempts->count()}}</div>
                <div class="mx-1 text-xs font-thin">|</div>
                <div>Re-Appear : {{$course_allocation->reappears->count()}}</div>
            </div>
        </div>
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @if(!$course_allocation->submitted_at)
    <div class="grid mt-12 p-8 border border-dashed border-slate-200">
        <h2 class="text-red-700">Before doing final submission, please do proof reading and make sure that every entry is correct. Once submitted, assessment data will be locked. </h2>
        <div class="flex items-center space-x-4 mt-3">
            <input type="checkbox" class="w-4 h-4" onchange="toggleSubmit()">
            <p>Ok, I have done proof reading and assessment data is ready for final submission</p>
        </div>
    </div>
    <form action="{{route('teacher.assessment.update', $course_allocation)}}" method="post" id='form_finish' class="mt-4 hidden">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn-red">Submit Now</button>
    </form>
    @else
    <div class="flex justify-center items-center mt-12 p-8 border border-dashed border-slate-200">
        <h2 class="text-red-700">Has been submitted on {{ $course_allocation->submitted_at ?? '' }} </h2>
    </div>
    @endif
</div>
@endsection
@section('script')
<script>
    function toggleSubmit() {
        $('#form_finish').toggleClass('hidden');
    }
</script>
@endsection