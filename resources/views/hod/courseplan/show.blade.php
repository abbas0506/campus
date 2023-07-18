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
            <i class="bx bx-time-five"></i> <span class="font-semibold ml-2">{{$section->cr()}} / {{$section->clas->scheme->creditHrsMax()}}</span>
        </p>
    </div>
    <div class="flex flex-col accordion mt-4">
        @foreach($section->semesters() as $semester)
        <div class="collapsible">
            <div @if($semester->id==session('semester_id')) class="head active" @else class="head" @endif>
                <h2 class="flex items-center">Semester {{$roman[$semester->id-$section->clas->first_semester_id]}}
                    <span class="text-sm text-slate-600"> :: {{$semester->short()}}</span>
                    <span class="bx bx-time-five ml-6 text-slate-400"></span>
                    <span class="text-xs text-slate-600 ml-2">{{$section->course_allocations()->where('slot','!=',0)->sumOfCreditHrs($semester->id)}} </span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">

                <div class="flex w-full border-b text-xs font-semibold py-1">
                    <div class="w-16 text-center">Slot</div>
                    <div class="w-24">Course Type</div>
                    <div class="w-16 text-center">Action</div>
                    <div class="flex flex-col flex-1">
                        <div class="flex w-full">
                            <div class="flex w-24">Code</div>
                            <div class="flex flex-1">Course</div>
                            <div class="flex flex-1">Teacher</div>
                            <div class="w-24 text-center">Action</div>
                        </div>

                    </div>
                </div>

                @foreach($section->clas->scheme->scheme_metas()->for($section->clas->semesterNo($semester->id))->get() as $meta)
                <div class="flex flex-col w-full even:bg-slate-100 py-1">
                    <div class="flex w-full">
                        <div class="w-16 text-center">{{$meta->slot}}</div>
                        <div class="w-24">{{$meta->course_type->name}}</div>
                        <div class="w-16 text-center my-1">
                            <a href="{{route('courseplan.courses',[$section->id, $meta->slot, $meta->course_type_id])}}" class="btn-teal">
                                <i class="bi bi-plus"></i>
                            </a>
                        </div>
                        <div class="flex flex-col flex-1 justify-center">
                            @foreach($section->course_allocations()->during($semester->id)->on($meta->slot)->get() as $course_allocation)
                            <div class="flex w-full my-1">
                                <div class="flex w-24">{{$course_allocation->course->code}}</div>
                                <div class="flex flex-1">{{$course_allocation->course->name}}<span class="ml-3 text-slate-400">{{$course_allocation->course->lblCr()}}</span></div>
                                <div class="flex flex-1">
                                    @if($course_allocation->teacher)
                                    {{$course_allocation->teacher->name}}
                                    @elseif($semester->id==session('semester_id'))
                                    <div class="flex items-center">
                                        <a href="{{route('courseplan.teachers',$course_allocation)}}">
                                            <i class="bx bx-paperclip text-indigo-600"></i>
                                        </a>
                                        <div class="text-xs text-slate-400 text-thin ml-2">(Assign Teacher)</div>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex items-center justify-center w-24">
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
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                @endforeach

                <div class="h-4 border-b border-dashed border-red-500 w-full "></div>
                <!-- old courses allocations  without slot no -->
                @foreach($section->course_allocations()->during($semester->id)->get() as $course_allocation)
                <div class="flex items-center w-full even:bg-slate-100 py-1">
                    <div class="flex w-36 text-xs">{{$course_allocation->course->code}}</div>
                    <div class="flex flex-1 text-xs">{{$course_allocation->course->name}} <span class="ml-3 text-slate-400">{{$course_allocation->course->lblCr()}}</span></div>
                    <div class="flex w-36 text-xs">{{$course_allocation->course->course_type->name}}</div>
                    <div class="flex flex-1 text-xs text-slate-600">
                        <form action="{{route('updateslot', $course_allocation)}}" method="post" class="flex items-center space-x-2">
                            @csrf
                            @method('PUT')
                            Slot:
                            <input type="number" name='slot' value="{{$course_allocation->slot}}" class="w-8">
                            <button type="submit" class="btn-orange">Update Slot</button>
                        </form>


                    </div>
                    <div class="flex flex-1 text-xs">
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