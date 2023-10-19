@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>{{$course_allocation->course->name}}</h2>
            <div class="bread-crumb">
                <a href="{{url('teacher')}}">Home</a>
                <div>/</div>
                <a href="{{route('teacher.mycourses.index')}}">My Courses</a>
                <div>/</div>
                <div>View</div>
            </div>
        </div>
        <div class="text-center">
            <div class="animate-bounce"><i class="bi-arrow-down"></i></div>
            <div><a href="{{route('teacher.assessment.show',$course_allocation)}}" class="text-blue-800 font-semibold">Assessment</a></div>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-red-600'>{{$course_allocation->section->title()}} </h2>
    </div>

    <div class="mt-8">
        <!-- search -->
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>
            <div class="flex flex-wrap items-center space-x-4 mt-4 text-xs">
                <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                    <span class="bx bx-group text-sm rounded-full"></span>
                </div>
                <div>Fresh : {{$course_allocation->first_attempts->count()}}</div>
                <div class="mx-1 text-xs font-thin">|</div>
                <div>Re-Appear : {{$course_allocation->reappears->count()}}</div>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        @php
        $sr=1;
        @endphp
        <div class="overflow-x-auto w-full">
            <table class="table-fixed w-full mt-2">
                <thead>
                    <tr>
                        <th class="w-8">Sr</th>
                        <th class="w-8"></th>
                        <th class="w-32">Roll No</th>
                        <th class="w-60">Name</th>
                        <th class="w-48">Father</th>
                        <th class="w-24">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- fresh students -->
                    @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                    <tr class="tr text-sm">
                        <td>{{$sr++}}</td>
                        <td>@if($first_attempt->student->gender=='M')
                            <i class="bx bx-male text-teal-600 text-lg"></i>
                            @else
                            <i class="bx bx-female text-indigo-400 text-lg"></i>
                            @endif
                        </td>
                        <td>{{$first_attempt->student->rollno}}</td>
                        <td class="text-left">{{$first_attempt->student->name}}</td>
                        <td class="text-left">{{$first_attempt->student->father}}</td>
                        <td>Fresh</td>
                    </tr>
                    @endforeach

                    <!-- reappears -->
                    @foreach($course_allocation->reappears_sorted() as $reappear)
                    <tr class="tr text-sm">
                        <td class="text-slate-400">{{$sr++}}</td>
                        <td>@if($reappear->first_attempt->student->gender=='M')
                            <i class="bx bx-male text-teal-600 text-lg"></i>
                            @else
                            <i class="bx bx-female text-indigo-400 text-lg"></i>
                            @endif
                        </td>
                        <td>{{$reappear->first_attempt->student->rollno}}</td>
                        <td class="text-left">{{$reappear->first_attempt->student->name}}</td>
                        <td class="text-left">{{$reappear->first_attempt->student->father}}</td>
                        <td>Reappear</td>
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
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>
    @endsection