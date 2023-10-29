@extends('layouts.teacher')
@section('page-content')
<div class="container bg-slate-100">
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <h2>{{ Auth::user()->name }}!</h2>
            <div class="bread-crumb">
                <div>Teacher</div>
                <div>/</div>
                <div>Home</div>
            </div>
        </div>
        <div class="text-slate-500">{{ today()->format('d/m/Y') }}</div>
    </div>

    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Allocated Courses</div>
                <div class="h2">{{$user->course_allocations()->count()}}</div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-book text-green-600"></i>
            </div>
        </a>
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Credit Hrs</div>
                <div class="h2">{{$user->course_allocations()->sumOfCr()}}</div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-clock text-teal-600"></i>
            </div>
        </a>

        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Allocated Students</div>
                <div class="h2">{{$user->allocated_fresh->count()+$user->allocated_reappears->count()}}</div>
            </div>
            <div class="ico bg-indigo-100">
                <i class="bi bi-person-circle text-indigo-400"></i>
            </div>
        </a>
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Result Submission</div>
                <div class="h2"> {{$user->course_allocations()->submitted()->count()}}/{{$user->course_allocations()->count()}}(
                    @if($user->course_allocations()->count())
                    {{round($user->course_allocations()->submitted()->count()/$user->course_allocations()->count()*100,1)}}
                    @else
                    0
                    @endif
                    %)
                </div>
            </div>
            <div class="ico bg-sky-100">
                <i class="bi bi-graph-up text-sky-600"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 mt-8 gap-6">
        <!-- middle panel  -->
        <div class="md:col-span-2">
            <!-- todays activity  -->
            <div class="p-4 bg-slate-50 mt-4">
                <h2>Today's Submission</h2>
                <div class="overflow-x-auto mt-2">
                    <table class="table-fixed w-full text-sm">
                        <thead>
                            <tr class="text-xs">
                                <th class="w-40">Class</th>
                                <th class="w-60">Course Name</th>
                                <th class='w-16'>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $last_section_id='';
                            @endphp


                            @foreach($user->course_allocations()->submitted()->today()->get() as $course_allocation)
                            <tr class="tr text-xs">
                                <td>
                                    @if($last_section_id!=$course_allocation->section->id)
                                    {{$course_allocation->section->title()}}
                                    @endif
                                </td>
                                <td class="text-left">{{$course_allocation->course->code}} | {{$course_allocation->course->name}} <span class="text-slate-400 text-xs">{{$course_allocation->course->lblCr()}}</span> <br> <span class="text-slate-400">{{$course_allocation->teacher->name}}</span></td>
                                <td>
                                    <a href="{{route('teacher.award.pdf',$course_allocation)}}" target="_blank">
                                        <i class="bi-file-earmark-pdf text-red-600 text-sm"></i>
                                    </a>
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

        </div>
        <!-- middle panel end -->
        <!-- right side bar starts -->
        <div class="">

            <div class="p-4 bg-sky-100">
                <h2>Profile</h2>
                <div class="flex flex-col">
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-person"></i></div>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-envelope-at"></i></div>
                        <div>{{ Auth::user()->email }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-phone"></i></div>
                        <div>{{ Auth::user()->phone }}</div>
                    </div>
                    <div class="divider border-blue-200 mt-4"></div>
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-key"></i></div>
                        <a href="{{route('passwords.edit')}}" class="link">Change Password</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection