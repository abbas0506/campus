@extends('layouts.hod')
@section('page-content')

@php
$roman=config('global.romans');
@endphp

<h1 class="mt-12">Schemes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{session('scheme')->title()}}-Semester {{$roman[session('semester_no')-1]}}
    </div>
</div>

<div class="container">

    @if ($errors->any())
    <div class="alert-danger mt-5">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex items-end justify-between mt-8">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <div class="ml-8">

            <label for="chkOtherCourses" class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hidden" id='eyeOpen'>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" id='eyeClosed'>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
                <span class="text-xs text-slate-500 ml-2">(Courses from other departments)</span>
            </label>
            <input type="checkbox" id='chkOtherCourses' onchange="toggleOtherCourses()" hidden>
        </div>

    </div>

    <table class="table-auto w-full mt-8">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            @if($course->department_id==session('department_id'))
            <tr class="tr">
                <td>
                    <div>{{$course->name}} ({{$course->credit_hrs_theory}}-{{$course->credit_hrs_practical}})</div>
                    <div class="text-slate-400 font-thin">{{$course->short}} | {{$course->code}}</div>
                </td>
                <td class="text-center">-</td>
                <td>
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="flex justify-center items-center ">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex justify-center items-center btn-indigo" onclick="assign('{{$course->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @else
            <tr class="tr other hidden">
                <td>
                    <div>{{$course->name}} ({{$course->credit_hrs_theory}}-{{$course->credit_hrs_practical}})</div>
                    <div class="text-slate-400 font-thin">{{$course->short}} | {{$course->code}}</div>
                </td>
                <td class="text-slate-400 text-xs text-center">{{$course->department->name}}</td>
                <td>
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="flex justify-center items-center ">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex justify-center items-center btn-indigo" onclick="assign('{{$course->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
</div>
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var checked = $('#chkOtherCourses').is(':checked');

        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                if ($(this).hasClass('other') && !checked) {
                    //do nothing
                } else
                    $(this).removeClass('hidden');
            }
        });
    }

    // function filter() {
    //     var searchtext = $('#department_filter option:selected').text().toLowerCase();
    //     $('.tr').each(function() {
    //         if (!(
    //                 $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
    //             )) {
    //             $(this).addClass('hidden');
    //         } else {
    //             $(this).removeClass('hidden');
    //         }
    //     });
    // }

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

    function toggleOtherCourses() {
        var checked = $('#chkOtherCourses').is(':checked');
        $('.tr').each(function() {
            if (!checked) {
                $('#eyeOpen').hide()
                $('#eyeClosed').show()

                if ($(this).hasClass('other')) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');

                }
            } else {
                $('#eyeOpen').show()
                $('#eyeClosed').hide()

                $(this).removeClass('hidden');

            }
        });
    }
</script>
@endsection