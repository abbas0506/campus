@extends('layouts.hod')
@section('page-content')
<div class="container bg-slate-100">
    <h2>Edit Course Allocation</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('courseplan')}}">Course Allocation</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <h1 class='text-red-600 mt-8'>{{$course_allocation->section->title()}}</h1>
    <h2 class='text-slate-600 mt-2'>Slot # {{$course_allocation->slot->slot_no}}</h2>
    @if($course_allocation->course()->exists())
    <div class="p-4 border border-dashed bg-white relative mt-4">
        <div class="absolute top-2 right-2 flex flex-row items-center space-x-2">
            @role('super')
            <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                    <i class="bx bx-trash hover:text-red-600"></i>
                </button>
            </form>
            @else
            <!-- hod can only delete if allocation has no assoicated results -->
            @if($course_allocation->teacher_id=='' || $course_allocation->first_attempts->count()==0)
            <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                    <i class="bx bx-trash hover:text-red-600"></i>
                </button>
            </form>
            @endif
            @endrole
            <a href="{{route('courseplan.courses',$course_allocation)}}"><i class="bx bx-pencil"></i></a>
        </div>

        <label for="" class="text-xs">Course Name</label>
        <div>{{$course_allocation->course->name}}</div>
    </div>
    <div class="p-4 border border-dashed bg-white relative mt-4">
        <a href="{{route('courseplan.teachers',$course_allocation)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
        <label for="" class="text-xs">Allocated Teacher</label>
        <div>{{$course_allocation->teacher->name ?? '(blank)'}}</div>
    </div>
    @else

    @foreach($course_allocation->slot->slot_options as $slot_option)
    <div class="flex flex-col p-4 border border-dashed bg-white relative mt-4">
        @if($slot_option->course()->exists())
        <div>{{$slot_option->course->name}}</div>
        @else
        @foreach($slot_option->availableCourses() as $course)

        @if($course_allocation->section->has_course($course->id))
        <!-- dont show link btn -->
        @else
        <div class="flex space-x-2 mt-1">
            <form action="{{route('courseplan.update',$course_allocation)}}" method="POST" id='del_form' class="flex items-center justify-center">
                @csrf
                @method('PATCH')
                <input type="text" name='course_id' value="{{$course->id}}" hidden>
                <button type="submit" class="btn-teal py-1 flex items-center">
                    <i class="bx bx-link"></i>
                </button>
            </form>
            <div>{{$course->name}}</div>
        </div>
        @endif
        @endforeach
        @endif

    </div>
    <!-- <div class="flex flex-row">
            <div class="w-1/2 text-left">{{$slot_option->course_type->name}} <span class="text-xs text-slate-400">({{$course_allocation->slot->cr}})</span></div>
            <div class="w-1/2 text-left">{{$slot_option->course->name ?? ''}}</div>
        </div>
        <div>{{$slot_option->availableCourses()->count()}}</div> -->
    @endforeach


    @endif



    <div class="flex flex-col gap-y-4 mt-8">
        @foreach($course_allocation->section->clas->scheme->slots()->for($course_allocation->section->clas->semesterNo(session('semester_id')))->get()->sortBy('slot_no') as $slot)
        <div class="gap-y-4">
            <div class="bg-slate-100 px-2 py-1 rounded-t-lg">
                <div class="flex items-center">
                    <h3 class="w-24">Slot # {{$slot->slot_no}}</h3>
                    <h3>{{$slot->lblCrsType()}} ({{$slot->cr}})</h3>
                </div>
            </div>
            <div class="border border-dashed p-2">
                <div class="md:pl-24 text-sm">
                    @foreach($course_allocation->section->course_allocations()->on($slot->id)->get() as $course_allocation)
                    <div class="flex flex-col lg:flex-row gap-2 py-1 w-full border-b">
                        <div class="flex flex-1 text-slate-800">
                            <div class="w-24 shrink-0">{{$course_allocation->course->code ?? ''}}</div>
                            <div class="">{{$course_allocation->course->name ?? ''}}</div>
                            <div class="ml-2">
                                <!-- delete button -->

                                <!-- super can delete even if allocation has some associated results as well -->
                                @role('super')
                                <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                                        <i class="bi-trash3 text-[12px]"></i>
                                    </button>
                                </form>
                                @else
                                <!-- hod can only delete if allocation has no assoicated results -->
                                @if($course_allocation->teacher_id=='' || $course_allocation->first_attempts->count()==0)
                                <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                                        <i class="bi-trash3 text-[12px]"></i>
                                    </button>
                                </form>
                                @endif
                                @endrole
                            </div>
                        </div>
                        <div class="flex flex-1 justify-between text-slate-800">
                            <div>{{ $course_allocation->teacher->name ?? ''}}</div>
                            <div>
                                <!-- teacher -->
                                @if($course_allocation->teacher_id!='')
                                <a href="{{route('courseplan.teachers',$course_allocation)}}" class="btn-blue text-xs pb-1 px-2">Replace</a>
                                @else
                                <a href="{{route('courseplan.teachers',$course_allocation)}}" class="flex items-center text-xs link">
                                    (Assign Teacher)
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex lg:pl-24 text-sm mt-2">
                    <a href="{{route('courseplan.courses',$course_allocation)}}" class="bg-teal-300 px-2 flex items-center text-sm">
                        Select Course
                    </a>
                </div>
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

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function filter() {
        var searchtext = $('#department_filter option:selected').text().toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function assign(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Course will be added to scheme !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form

                $('#assign_form' + formid).submit();
            }
        });
    }
</script>
@endsection