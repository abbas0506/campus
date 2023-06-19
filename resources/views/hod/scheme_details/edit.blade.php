@extends('layouts.hod')
@section('page-content')

@php
$roman=config('global.romans');
@endphp

<h1>Study Scheme</h1>
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
        <div class="flex relative">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>

    <div class="flex items-end justify-between mt-8">

        <div class="bg-teal-100">Choose for Scheme: <span class="font-semibold">{{session('scheme')->title()}}-Semester {{$roman[session('semester_no')-1]}}</span> </div>
        <div class="ml-8">
            <label for="chkOtherCourses" class="flex items-center text-sm">
                <div class="hidden p-1 bg-teal-400 hover:cursor-pointer" id='eyeOpen'><i class="bx bx-show-alt text-lg"></i></div>
                <div class='p-1 bg-teal-400 hover:cursor-pointer' id='eyeClosed'><i class="bx bx-hide text-lg"></i></div>
                <div class="text-xs text-slate-500 ml-2">(Courses from all departments)</div>
            </label>
            <input type="checkbox" id='chkOtherCourses' onchange="toggleOtherCourses()" hidden>
        </div>

    </div>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Code</th>
                <th>Course</th>
                <th>Type</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->sortBy('code') as $course)
            @if($course->department_id==session('department_id'))
            <tr class="tr">
                <td class="text-center">{{$course->code}}</td>
                <td>{{$course->name}} <span class="text-slate-400 ml-2">({{$course->credit_hrs_theory}}-{{$course->credit_hrs_practical}})</span></td>
                <td class="text-center font-thin">{{$course->course_type->name}}</td>
                <td class="text-center font-thin">Self</td>
                <td>
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="flex justify-center items-center ">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex justify-center items-center btn-teal" onclick="assign('{{$course->id}}')">
                            <i class="bx bx-link"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @else
            <tr class="tr other hidden">
                <td class="text-center">{{$course->code}}</td>
                <td>{{$course->name}} <span class="text-slate-400 ml-2">({{$course->credit_hrs_theory}}-{{$course->credit_hrs_practical}})</span></td>
                <td class="text-center font-thin">{{$course->course_type->name}}</td>
                <td class="text-center font-thin">{{str_replace("Department of ","",$course->department->name)}}</td>
                <td>
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="flex justify-center items-center ">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex justify-center items-center btn-teal" onclick="assign('{{$course->id}}')">
                            <i class="bx bx-link"></i>
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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
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