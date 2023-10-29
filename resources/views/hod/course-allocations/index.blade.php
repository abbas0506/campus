@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Course Allocations</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Course Allocations</div>
    </div>

    <!-- search -->
    <div class="relative mt-4 md:w-1/3">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="overflow-x-auto mt-4">
        <!-- submitted results -->
        <div class="overflow-x-auto">
            <table class="table-fixed w-full text-sm">
                <thead>
                    <tr class="text-xs">
                        <th class="w-40">Class</th>
                        <th class="w-24">Code</th>
                        <th class="w-60">Course Name</th>
                        <th class="w-16">Fresh</th>
                        <th class="w-16">Re</th>
                        <th class='w-32'>Submission</th>
                        <th class='w-24'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $last_section_id='';
                    @endphp


                    @foreach($department->current_allocations()->get() as $course_allocation)
                    <tr class="tr text-xs">
                        <td>
                            @if($last_section_id!=$course_allocation->section->id)
                            {{$course_allocation->section->title()}}
                            @endif
                        </td>
                        <td>{{$course_allocation->course->code}}</td>
                        <td class="text-left">{{$course_allocation->course->name}} <span class="text-slate-400 text-xs">{{$course_allocation->course->lblCr()}}</span> <br> <span class="text-slate-400">{{$course_allocation->teacher->name}}</span></td>
                        <td>{{$course_allocation->first_attempts->count()}}</td>
                        <td>{{$course_allocation->reappears->count()}}</td>
                        <td>{{$course_allocation->submitted_at}}</td>
                        <td>
                            @if($course_allocation->submitted_at)
                            <a href="{{route('hod.assessment.pdf',$course_allocation)}}" target="_blank" class="text-blue-600 text-sm"><i class="bi-printer"></i></a>
                            @endif
                        </td>
                    </tr>

                    @php
                    if($last_section_id!=$course_allocation->section->id)
                    $last_section_id=$course_allocation->section->id;
                    @endphp

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
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
    </script>

    @endsection