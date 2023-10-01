@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Course Fixation on Slot</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('schemes.index')}}">Programs & Schemes</a>
        <div>/</div>
        <a href="{{route('schemes.show', $slot_option->slot->scheme)}}">{{$slot_option->slot->scheme->subtitle()}}</a>
        <div>/</div>
        <div>Courses</div>
    </div>

    @php
    $roman = config('global.romans');
    @endphp



    <h1 class="text-red-600 mt-8">Slot # {{$slot_option->slot->slot_no}} <span class=""> {{$slot_option->course_type->name}} ({{$slot_option->slot->cr}})</span></h1>
    <div class="flex items-center">
        <h2>{{$slot_option->slot->scheme->program->short}}</h2>
        <span class="chevron-right mx-1"></span>
        <div class="flex items-center text-blue-600 link">
            {{$slot_option->slot->scheme->subtitle()}}
            (Semester-{{$roman[$slot_option->slot->semester_no-1]}})
            </a>
        </div>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-16">Action</th>
                    <th class="w-24">Code</th>
                    <th class="w-72 text-left">Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses->sortBy('code') as $course)
                <tr class="tr">
                    <td class="">
                        <form action="{{route('slot-options.update',$slot_option)}}" method="POST" class="flex items-center justify-center">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="course_id" value="{{$course->id}}" class="hidden">
                            <button type="submit" class="btn-teal py-0">
                                <i class="bx bx-link"></i>
                            </button>
                        </form>
                    </td>
                    <td>{{$course->code}}</td>
                    <td class="text-left">{{$course->name}} <span class="text-slate-500 text-xs">{{($course->lblCr())}}</span></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
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