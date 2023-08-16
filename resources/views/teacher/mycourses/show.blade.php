@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <h2>My Courses</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('mycourses.index')}}">My Courses</a>
        <div>/</div>
        <div>View</div>
    </div>
    <div class="flex flex-col md:items-center md:flex-row gap-y-4 mt-8">
        <div class="flex-1">
            <h1 class="text-red-600">{{$course_allocation->course->name}}</h1>
            <div class="text-sm">{{$course_allocation->section->title()}}</div>
        </div>
        <div class="md:w-60 hover:cursor-pointer" onclick="toggleResultBar()">
            <!-- <div class="md:w-60 hover:cursor-pointer"> -->
            <!-- <a href="{{route('assessment.show',$course_allocation)}}" class="pallet-box border"> -->
            <div class="pallet-box border">
                <div class="flex-1">
                    <div class="title">Result Status</div>
                    <h2>@if($course_allocation->submitted_at!='') Submitted @else Pending @endif </h2>
                </div>
                <div class="ico ml-8 bg-blue-100">
                    @if($course_allocation->submitted_at!='')
                    <i class="bi-lock text-red-600 text-2xl"></i>
                    @else
                    <i class="bi-unlock text-blue-600 text-2xl"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id='result_bar' class="overflow-x-auto w-full mt-4 hidden">
        <table class="table-fixed w-full">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="w-24">Assessment</th>
                    <th class="w-8">Pass Ratio</th>
                    <th class="w-16">Avg Marks</th>
                    <th class="w-12">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td class="font-semibold">Formative</td>
                    <td>%</td>
                    <td>%</td>
                    <td>
                        <a href="{{route('formative.edit', $course_allocation)}}"><i class="bi-pencil-square"></i></a>
                    </td>
                </tr>
                <tr class="text-center">
                    <td class="font-semibold text-center">Summative</td>
                    <td>%</td>
                    <td>%</td>
                    <td>
                        <a href="{{route('summative.edit', $course_allocation)}}"><i class="bi-pencil-square"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>


    <div class="mt-8">
        <!-- search -->
        <div class="flex relative w-full md:w-1/3 mt-8">
            <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- Fresh students -->
        <section id="tab_fresh" class="mt-8">
            <div class="flex items-end justify-between">
                <div class="flex flex-wrap items-center space-x-4">
                    <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                        <span class="bx bx-group rounded-full"></span>
                    </div>
                    <div class="tab active">Fresh : {{$course_allocation->first_attempts->count()}}</div>
                    <div class="mx-1 text-xs font-thin">|</div>
                    <div class="tab" onclick="toggle('f')">Re-Appear : {{$course_allocation->reappears->count()}}</div>
                </div>
                <a href="{{route('enroll.fa', $course_allocation)}}" class="btn-teal">
                    <i class="bi bi-person-add"></i>
                </a>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="table-fixed w-full mt-4">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="w-60">Name</th>
                            <th class="w-48">Father</th>
                            <th class="w-24">Status</th>
                            <th class='text-center w-24'>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                        <tr class="tr border-b ">
                            <td class="py-2">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        @if($first_attempt->student->gender=='M')
                                        <i class="bx bx-male text-teal-600 text-lg"></i>
                                        @else
                                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-slate-600">{{$first_attempt->student->name}}</div>
                                        <div class="text-slate-600 text-sm">
                                            {{$first_attempt->student->rollno}}
                                        </div>
                                    </div>

                                </div>

                            </td>
                            <td hidden>{{$first_attempt->student->gender}}</td>
                            <td class="py-2 text-slate-600 text-sm">
                                {{$first_attempt->student->father}}
                            </td>
                            <td class="text-center">Fresh</td>

                            <td>
                                <form action="{{route('first_attempts.destroy',$first_attempt)}}" method="POST" id='del_form{{$first_attempt->student->id}}' class="flex items-center justify-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$first_attempt->student->id}}')">
                                        <i class="bi bi-person-dash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </section>

        <!-- Reappearig students -->
        <section id='tab_reappear' class="mt-8 hidden">
            <div class="flex items-end justify-between py-2 space-x-5 ">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                        <span class="bx bx-group rounded-full"></span>
                    </div>
                    <div class="tab" onclick="toggle('r')">Fresh : {{$course_allocation->first_attempts->count()}}</div>
                    <div class="mx-1 text-xs font-thin">|</div>
                    <div class="tab active">Re-Appear : {{$course_allocation->reappears->count()}}</div>
                </div>
                <a href="{{route('enroll.ra', $course_allocation)}}" class="btn-teal">
                    <i class="bi bi-person-add"></i>
                </a>
            </div>

            <table class="table-auto w-full mt-4">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th>Name</th>
                        <th>Father</th>
                        <th>Status</th>
                        <th class='text-center'>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course_allocation->reappears_sorted() as $reappear)
                    <tr class="tr border-b ">
                        <td class="py-2">
                            <div class="flex items-center space-x-4">
                                <div>
                                    @if($reappear->first_attempt->student->gender=='M')
                                    <i class="bx bx-male text-teal-600 text-lg"></i>
                                    @else
                                    <i class="bx bx-female text-indigo-400 text-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-slate-600">{{$reappear->first_attempt->student->name}}</div>
                                    <div class="text-slate-600 text-sm">
                                        {{$reappear->first_attempt->student->rollno}}
                                        @if($reappear->first_attempt->student->regno)
                                        | {{$reappear->first_attempt->student->regno}}
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </td>
                        <td hidden>{{$reappear->first_attempt->student->gender}}</td>
                        <td class="py-2 text-slate-600 text-sm">
                            {{$reappear->first_attempt->student->father}}
                        </td>
                        <td class="text-center">Reappear</td>
                        <td>
                            <div class="flex justify-center items-center py-2">
                                <form action="{{route('reappears.destroy',$reappear)}}" method="POST" id='del_form{{$reappear->first_attempt->student->id}}' class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$reappear->first_attempt->student->id}}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
    @endsection
    @section('script')
    <script type="text/javascript">
        function del(formid) {

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
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

        function toggle(opt) {
            if (opt == "f") {
                $("#tab_fresh").slideUp();
                $("#tab_reappear").slideDown();
            }
            if (opt == "r") {
                $("#tab_fresh").slideDown();
                $("#tab_reappear").slideUp();
            }
        }

        function toggleResultBar() {
            $('#result_bar').slideToggle().delay(500);
        }
    </script>

    @endsection