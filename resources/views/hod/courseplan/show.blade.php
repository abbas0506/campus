@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('courseplan')}}">Course Allocation | Step II</a></h1>
<div class="bread-crumb">{{$section->title()}}</div>

<div class="container mt-12">
    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif
    @php
    $roman=config('global.romans');
    @endphp
    <div class="flex items-center space-x-4">
        <p class="bg-teal-600 text-md font-semibold px-2 text-white">Scheme: {{$section->clas->scheme->title()}}</p>
        <p class="flex items-center bg-orange-100 px-2">
            <i class="bx bx-time-five"></i> <span class="font-semibold ml-2">{{$section->course_allocations()->allocatedCr()}} / {{$section->clas->scheme->slots->sum('cr')}} ({{$section->clas->scheme->program->cr}})</span>
        </p>
    </div>
    <div class="flex flex-col accordion mt-4">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="bx bx-time-five ml-6 text-slate-400"></span>
                    <span class="text-xs text-slate-600 ml-2">{{$section->course_allocations()->during($semester->id)->allocatedCr()}} / {{$section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->sum('cr') }}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="flex w-full border-b text-xs font-semibold py-1">
                    <div class="w-16 text-center">Slot</div>
                    <div class="w-40">Course Type</div>
                    <div class="flex flex-col flex-1">
                        <div class="flex w-full">
                            <div class="flex w-24">Code</div>
                            <div class="flex flex-1">Course</div>
                            <div class="flex flex-1">Teacher</div>
                        </div>

                    </div>
                </div>

                @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo($semester->id))->get() as $slot)
                <div class="flex flex-col w-full even:bg-slate-100 py-1 text-xs">
                    <div class="flex w-full">
                        <div class="w-16 text-center">{{$slot->slot_no}}</div>
                        <div class="w-40">{{$slot->lblCrsType()}} ({{$slot->cr}})</div>
                        <div class="flex flex-col flex-1 justify-center">
                            @foreach($section->course_allocations()->during($semester->id)->on($slot->id)->get() as $course_allocation)
                            <div class="flex w-full my-1">
                                <div class="flex w-24">{{$course_allocation->course->code}} </div>
                                <div class="flex flex-1">{{$course_allocation->course->name}}<span class="ml-3 text-slate-400">{{$course_allocation->course->lblCr()}}</span></div>
                                <div class="flex flex-1">
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
                </div>
                @endforeach

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