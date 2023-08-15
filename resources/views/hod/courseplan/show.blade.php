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
    <div class="flex flex-wrap items-center gap-4 mt-8">
        <p class="bg-teal-600 text-md font-semibold px-2 text-white">Scheme: {{$section->clas->scheme->title()}}</p>
        <p class="flex items-center bg-orange-100 px-2">
            <i class="bx bx-time-five"></i> <span class="font-semibold ml-2">{{$section->course_allocations()->allocatedCr()}} / {{$section->clas->scheme->slots->sum('cr')}} ({{$section->clas->scheme->program->cr}})</span>
        </p>
    </div>
    <div class="flex flex-col accordion mt-4">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id+$section->clas->program->intake-1]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="bx bx-time-five ml-6 text-slate-400"></span>
                    <span class="text-xs text-slate-600 ml-2">{{$section->course_allocations()->during($semester->id)->allocatedCr()}} / {{$section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->sum('cr') }}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="flex flex-col w-full even:bg-slate-100 py-1 text-xs overflow-x-auto">
                    <div class="flex w-full border-b text-xs font-semibold py-1">
                        <div class="w-16 shrink-0 text-center">Slot</div>
                        <div class="w-40 shrink-0">Course Type</div>
                        <!-- <div class="flex flex-col flex-1">
                            <div class="flex w-full"> -->
                        <div class="shrink-0 w-24">Code</div>
                        <div class="shrink-0 w-64">Course</div>
                        <div class="shrink-0 w-64">Teacher</div>
                        <!-- </div>

                        </div> -->
                    </div>
                    @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->get() as $slot)

                    <div class="flex">
                        <div class="shrink-0 w-16 text-center">{{$slot->slot_no}} </div>
                        <div class="shrink-0 w-40">{{$slot->lblCrsType()}} ({{$slot->cr}})</div>
                        <div class="flex flex-col justify-center">
                            @foreach($section->course_allocations()->during($semester->id)->on($slot->id)->get() as $course_allocation)
                            <div class="flex w-full my-1">
                                <div class="shrink-0 w-24">{{$course_allocation->id}}{{$course_allocation->course->code}} </div>
                                <div class="shrink-0 w-64">{{$course_allocation->course->name}}<span class="ml-3 text-slate-400">{{$course_allocation->course->lblCr()}}</span></div>
                                <div class="shrink-0 w-64">
                                    @if($course_allocation->teacher)
                                    {{$course_allocation->teacher->name ?? ''}}
                                    @else
                                    <div class="text-slate-400">(blank)</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                    @endforeach
                </div>

                @if($semester->id==session('semester_id'))
                <div class="flex w-full py-2">
                    <a href="{{route('courseplan.edit',$section)}}" class="btn-teal flex items-center"><i class="bi-pencil text-[10px] mr-2"></i> Edit Course Plan </a>
                </div>
                @endif

            </div>

        </div>

        @endforeach
    </div>
</div>

<script type="text/javascript">
    function delme(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_form' + formid).submit();
            }
        });
    }

    function delElective(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "All related data will be lost! Do only of if you know the consequences.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_elective_form' + formid).submit();
            }
        });
    }
</script>

@endsection