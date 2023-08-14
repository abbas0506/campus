@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <h2>My Courses</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>My Courses</div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle text-2xl w-8"></i>
        <ul class="text-sm">
            <li>Courses are being shown only from selected semester ({{App\Models\Semester::find(session('semester_id'))->title()}}) </li>
            <li>If you dont see any course, contact respective department's HOD for course allocation.</li>
        </ul>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap items-center space-x-4 mt-16">
        <h2 class="text-red-600">Total Allocations: {{$teacher->allocations()->count()}}</h2>
        <h2> <i class="bi-clock"></i> {{$teacher->allocations()->sum('cr')}} </h2>
    </div>
    <div class="flex flex-col accordion mt-4">

        @foreach($shifts as $shift)
        <div class="collapsible">
            <div class="head">
                <h2 class="flex items-center space-x-2 ">
                    {{$shift->name}}
                    <span class="text-xs ml-4 text-slate-600">{{$teacher->allocations()->where('short',$shift->short)->count()}}</span>
                    <span class="text-xs text-slate-600">({{$teacher->allocations()->where('short',$shift->short)->sum('cr')}})</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="overflow-x-auto w-full">
                    <table class="table-fixed borderless w-full">
                        <thead>
                            <tr>
                                <th class="w-8">#</th>
                                <th class="w-24">Code</th>
                                <th class="w-60 text-left">Course</th>
                                <th class="w-8">Cr</th>
                                <th class="w-48">Class & Section</th>
                                <th class="w-16">Fresh</th>
                                <th class="w-16">Re</th>
                                <th class="w-16">Result</th>
                                <th class="w-16">Pass</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($teacher->allocations()->get()->where('short',$shift->short) as $course_allocation)
                            <tr>
                                <td class="text-center">{{$i++}}</td>
                                <td class="text-center">
                                    <a href="{{route('mycourses.show',$course_allocation->id)}}" class="link">
                                        {{$course_allocation->course->code}}
                                    </a>
                                </td>
                                <td>{{$course_allocation->course->name}} <span class="text-slate-400 text-sm">{{$course_allocation->course->lblCr()}}</span> </td>
                                <td>{{$course_allocation->slot->cr}}</td>
                                <td>{{$course_allocation->section->title()}}</td>
                                <td class="text-center">{{$course_allocation->first_attempts()->count()}}</td>
                                <td class="text-center">{{$course_allocation->reappears()->count()}}</td>
                                <td class="text-center">%</td>
                                <td class="text-center">%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        @endforeach
    </div>



    <!--  -->

    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 md:gap-8 mt-12 md:w-4/5 mx-auto">
        
        @foreach($teacher->allocations()->get() as $course_allocation)
        <div class="card relative flex flex-col justify-between items-center border p-4 bg-slate-50">
            <div class="absolute right-0 top-0 bg-teal-200 px-2 py-0 text-sm">
                <i class="bx bx-group"></i>
                {{$course_allocation->first_attempts->count()+$course_allocation->reappears->count()}}
            </div>
            <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex flex-col justify-center items-center">
                <i class="bx bx-book bx-md mt-4 text-slate-600"></i>
                <div class="text-xs mt-3">{{$course_allocation->course->code}}</div>
                <div class="font-semibold text-teal-800 mt-2 w-full text-center">
                    {{$course_allocation->course->name}}
                </div>
                <div class="text-xs mt-2 mb-6">{{$course_allocation->section->title()}}</div>
            </a>
            <div class="slide-up">
                <a href="{{route('mycourses.show',$course_allocation->id)}}" class="flex flex-1 items-center justify-center bg-teal-200 hover:bg-teal-300 rounded-t-lg">
                    Enroll
                    <i class="bi bi-person-add text-[14px] ml-1"></i>
                </a>
                <a href="{{route('formative.edit', $course_allocation)}}" class="flex flex-1 items-center justify-center bg-blue-200 hover:bg-blue-300 rounded-t-lg">
                    Formative
                    <i class="bx bx-pencil text-[12px] ml-1"></i>
                </a>
                <a href="{{route('summative.edit', $course_allocation)}}" class="flex flex-1 items-center justify-center bg-red-200 hover:bg-red-300 px-2 rounded-t-lg">
                    Summative
                    <i class="bx bx-pencil text-[12px] ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach

    </div> -->

</div>
@endsection