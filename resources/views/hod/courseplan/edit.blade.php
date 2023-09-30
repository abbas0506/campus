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

    <h1 class='text-red-600 mt-8'>{{$course_allocation->section->title()}}</h1>
    <h2 class='mt-4'>Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</h2>


    <div class="p-4 border border-dashed bg-white relative mt-4">
        <div class="absolute top-2 right-2 flex flex-row items-center space-x-2">

            @if($course_allocation->course()->exists() && (Auth::user()->hasRole('super') || !$course_allocation->first_attempts()->exists()))
            <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                    <i class="bx bx-trash hover:text-red-600"></i>
                </button>
            </form>
            @endif

            @if(!$course_allocation->teacher()->exists())
            <a href="{{route('courseplan.courses',$course_allocation)}}"><i class="bx bx-pencil"></i></a>
            @endif
        </div>

        <label for="" class="text-xs">Course</label>
        <div class="flex flex-wrap">
            @if($course_allocation->course()->exists())
            <div class="w-24">{{$course_allocation->course->code }}</div>
            <div class="">{{$course_allocation->course->name }} <span class="text-slate-400 text-xs">{{ $course_allocation->course->lblCr() }}</span></div>
            @else
            <div>(blank)</div>
            @endif
        </div>
    </div>
    <div class="p-4 border border-dashed bg-white relative mt-4">
        @if($course_allocation->course()->exists())
        <a href="{{route('courseplan.teachers',$course_allocation)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
        @endif
        <label for="" class="text-xs">Allocated Teacher</label>
        <div>{{$course_allocation->teacher->name ?? '(blank)'}}</div>
    </div>
    <div class="flex justify-end w-full mt-4">
        <a href="{{route('courseplan.show', $course_allocation->section_id)}}" class="btn btn-blue">Go Back</a>
    </div>
    @endsection
    @section('script')
    <script type="text/javascript">
        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

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
    </script>
    @endsection