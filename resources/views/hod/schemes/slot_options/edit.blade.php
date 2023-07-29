@extends('layouts.hod')
@section('page-content')

<h1>List of Available Courses</h1>
@php
$roman = config('global.romans');
@endphp
<div class="flex items-center mt-3">
    <h2>{{$slot_option->slot->scheme->program->short}}</h2>
    <span class="chevron-right mx-1"></span>
    <a href="{{route('schemes.show', $slot_option->slot->scheme)}}" class="flex items-center text-blue-600 link">
        {{$slot_option->slot->scheme->subtitle()}}
        ({{$roman[$slot_option->slot->semester_no-1]}})
    </a>
</div>
<h2 class="mt-2">Slot # {{$slot_option->slot->slot_no}}</h2>
<div class="container mx-auto mt-8">

    <div class="flex items-end">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <i class="bi-search absolute top-2 right-2"></i>
        </div>

    </div>

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif


    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->sortBy('code') as $course)
            <tr class="tr">
                <td class="text-center">{{$course->code}}</td>
                <td>{{$course->name}}</td>
                <td class="text-center">{{$course->course_type->name}}</td>

                <td class="">

                    <form action="{{route('slot-options.update',$slot_option)}}" method="POST" class="py-2 flex items-center justify-center">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="course_id" value="{{$course->id}}" class="hidden">
                        <button type="submit" class="btn-teal py-0">
                            <i class="bx bx-link"></i>
                        </button>
                    </form>


                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<script type="text/javascript">
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