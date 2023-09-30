@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Course Allocation</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('courseplan')}}">Course Allocations</a>
        <div>/</div>
        <div>Step II</div>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @php
    $roman=config('global.romans');
    @endphp

    <h1 class='text-red-600 mt-8'>{{$section->title()}} </h1>
    <p class="bg-teal-600 text-md font-semibold px-2 text-white">Scheme: {{$section->clas->scheme->title()}}</p>

    @php
    $semester=App\Models\Semester::find(session('semester_id'));
    @endphp
    <div class="bg-slate-100 p-2 mt-4">
        <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id+$section->clas->program->intake-1]}}
            <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
            <span class="bx bx-time-five ml-6 text-slate-400"></span>
            <span class="text-xs text-slate-600 ml-2"> {{$section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->sum('cr') }}</span>
        </h2>
    </div>

    <div class="flex flex-col w-full even:bg-slate-100 py-1 text-sm overflow-x-auto">
        <div class="flex w-full font-semibold py-1">
            <div class="w-16 shrink-0 text-center">Slot</div>
            <div class="w-32 shrink-0">Course Type</div>
            <div class="shrink-0 w-24">Code</div>
            <div class="shrink-0 w-64">Course</div>
            <div class="shrink-0 w-64">Teacher</div>
        </div>

        @php
        $prev_slot_no='';
        @endphp

        <div class="border border-dashed">
            @foreach($section->course_allocations()->for($semester->id)->get() as $course_allocation)
            <div class="flex w-full py-1">
                @if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                <div class="shrink-0 w-16 text-center">{{$course_allocation->slot_option->slot->slot_no}}</div>
                @else
                <div class="shrink-0 w-16 text-center"></div>
                @endif
                <div class="flex shrink-0 w-32">
                    <a href="{{route('courseplan.edit',$course_allocation)}}" class=" text-left link">
                        {{$course_allocation->slot_option->course_type->name}}
                    </a>
                    <span class="text-slate-400 text-xs ml-2">({{ $course_allocation->slot_option->slot->cr }})</span>
                </div>
                <div class="shrink-0 w-24">{{ $course_allocation->course->code ?? '' }}</div>
                <div class="shrink-0 w-64">{{ $course_allocation->course->name ?? '' }}</div>
                <div class="shrink-0 w-64">{{$course_allocation->teacher->name ?? ''}}</div>
            </div>

            <!-- show slot no only for once to make slot options' group  -->
            @php
            if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
            $prev_slot_no=$course_allocation->slot_option->slot->slot_no;
            @endphp

            @endforeach
        </div>
    </div>
</div>
@endsection