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
        <p class="flex items-center bg-orange-100 px-2">Scheduled:
            <i class="bx bx-book ml-2"></i> <span class="font-semibold ml-2">{{$section->course_allocations->count()}} / {{$section->clas->scheme->scheme_details->count()}}</span>
            <span class="mx-4">|</span>
            <i class="bx bx-time-five"></i> <span class="font-semibold ml-2">{{$section->cr()}} / {{$section->clas->scheme->creditHrsMax()}}</span>
        </p>
    </div>
    <div class="flex flex-col accordion mt-4">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="bx bx-book text-slate-400 ml-6"></span>
                    <span class="text-xs text-slate-600 ml-2">{{$section->course_allocations()->during($semester->id)->count()}}</span>
                    <span class="bx bx-time-five ml-6 text-slate-400"></span>
                    <span class="text-xs text-slate-600 ml-2">{{$section->course_allocations()->sumOfCreditHrs($semester->id)}} </span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">

                @foreach($section->course_allocations()->during($semester->id)->get() as $course_allocation)
                <div class="flex items-center w-full even:bg-slate-100 py-1">
                    <div class="flex w-36 text-sm">{{$course_allocation->course->code}}</div>
                    <div class="flex flex-1 text-sm">{{$course_allocation->course->name}} <span class="ml-3 text-slate-400">{{$course_allocation->course->lblCr()}}</span></div>
                    <div class="flex flex-1 text-xs text-slate-600">Slot:{{$course_allocation->slot}}</div>
                    <div class="flex flex-1 text-sm">
                        <!-- if teacher name given, show name ... else show link icon -->
                        @if($course_allocation->teacher)
                        {{$course_allocation->teacher->name}}
                        @elseif($semester->id==session('semester_id'))
                        <div class="flex items-center py-2">
                            <a href="{{route('courseplan.teachers',$course_allocation)}}">
                                <i class="bx bx-paperclip text-indigo-600"></i>
                            </a>
                            <div class="text-xs text-slate-400 text-thin ml-2">(Assign Teacher)</div>
                        </div>

                        @endif
                    </div>
                    <!-- show remove icon for each allocation -->
                    @if($semester->id==session('semester_id'))
                    @if($course_allocation->teacher)
                    <a href="{{route('courseplan.replace',$course_allocation->id)}}" class="btn-blue text-xs pb-1 px-2">Replace</a>
                    @else
                    <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_elective_form{{$course_allocation->id}}'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-red pb-1 px-2 text-xs" onclick="delElective('{{$course_allocation->id}}')">
                            Remove
                        </button>
                    </form>
                    @endif
                    @endif

                </div>
                @endforeach
                <!-- allow course addition only for current semester -->
                @if($semester->id==session('semester_id'))
                <div class="w-full mt-2">
                    <a href="{{route('courseplan.courses', $section)}}" class="flex items-center btn-teal text-sm float-left">
                        Add Course
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
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