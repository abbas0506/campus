@extends('layouts.hod')
@section('page-content')
<div class="container">
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

    <div class="flex flex-col gap-y-4 mt-8">
        @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo(session('semester_id')))->get()->sortBy('slot_no') as $slot)
        <div class="gap-y-4">
            <div class="bg-slate-100 px-2 py-1 rounded-t-lg">
                <div class="flex items-center">
                    <h3 class="w-24">Slot # {{$slot->slot_no}}</h3>
                    <h3>{{$slot->lblCrsType()}} ({{$slot->cr}})</h3>
                </div>
            </div>
            <div class="border border-dashed p-2">
                <div class="md:pl-24 text-sm">
                    @foreach($section->course_allocations()->on($slot->id)->get() as $course_allocation)
                    <div class="flex flex-col lg:flex-row gap-2 py-1 w-full border-b">
                        <div class="flex flex-1 text-slate-800">
                            <div class="w-24 shrink-0">{{$course_allocation->course->code}}</div>
                            <div class="">{{$course_allocation->course->name}}</div>
                            <div class="ml-2">
                                <!-- delete button -->
                                @if($course_allocation->teacher_id=='' || $course_allocation->first_attempts->count()==0)
                                <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                                        <i class="bi-trash3 text-[12px]"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-1 justify-between text-slate-800">
                            <div>{{ $course_allocation->teacher->name ?? ''}}</div>
                            <div>
                                <!-- teacher -->
                                @if($course_allocation->teacher_id!='')
                                <a href="{{route('courseplan.replace',$course_allocation->id)}}" class="btn-blue text-xs pb-1 px-2">Replace</a>
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
                    <a href="{{route('courseplan.courses',[$section,$slot])}}" class="bg-teal-300 px-2 flex items-center text-sm">
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