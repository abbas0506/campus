@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Semester Plan </h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.semester-plan.index')}}">Semester Plan</a>
        <div>/</div>
        <div>{{$section->title()}}</div>
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

    <div class="flex items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-red-600'>{{$section->title()}} </h2>
        <p class="text-slate-600 text-sm">( Scheme: {{$section->clas->scheme->semester->title()}} )</p>
    </div>

    @php
    $semester=App\Models\Semester::find(session('semester_id'));
    @endphp
    <div class="py-2 mt-4">
        <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id+$section->clas->program->intake-1]}}
            <span class="text-sm text-slate-600"> &nbsp({{$semester->title()}})</span>
            <span class="bx bx-time-five ml-6 text-slate-400"></span>
            <span class="text-xs text-slate-600 ml-2"> {{$section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->sum('cr') }}</span>
        </h2>
    </div>

    @php
    $prev_slot_no='';
    @endphp

    <div class="overflow-x-auto w-full">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-12">Slot</th>
                    <th class="w-40">Course Type</th>
                    <th class="w-32">Code</th>
                    <th class="w-64">Course</th>
                    <th class="w-64">Teacher</th>
                </tr>
            </thead>
            <tbody>
                @foreach($section->course_allocations()->for($semester->id)->get() as $course_allocation)
                <tr class="tr">
                    <td>
                        @if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                        {{$course_allocation->slot_option->slot->slot_no}}
                        @endif
                    </td>
                    <td class="text-left">
                        <a href="{{route('hod.course-allocations.show',$course_allocation)}}" class=" text-left link">
                            {{$course_allocation->slot_option->course_type->name}}
                        </a>
                        <span class="text-slate-400 text-xs ml-1">({{ $course_allocation->slot_option->slot->cr }})</span>
                    </td>
                    @if($course_allocation->course()->exists())
                    <td>{{ $course_allocation->course->code }}</td>
                    <td class="text-left">{{ $course_allocation->course->name }}<span class="text-slate-400 text-xs ml-1"> {{ $course_allocation->course->lblCr() }}</span></td>
                    <td class="text-left">{{ $course_allocation->teacher->name??'' }}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <!-- show slot no only for once to make slot options' group  -->
                @php
                if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                $prev_slot_no=$course_allocation->slot_option->slot->slot_no;
                @endphp
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection