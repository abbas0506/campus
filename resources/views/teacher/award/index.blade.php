@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <h2>Award Lists</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Award Lists</div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle text-2xl w-8"></i>
        <ul class="text-sm">
            <li>Courses are being shown only from selected semester ({{App\Models\Semester::find(session('semester_id'))->title()}}) </li>
            <li>If you dont see any course, contact respective department's HOD for course allocation.</li>
        </ul>
    </div>

    <div class="w-full mt-12">

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
                                <th class="w-16">Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($teacher->allocations()->get()->where('short',$shift->short) as $course_allocation)
                            <tr>
                                <td class="text-center">{{$i++}}</td>
                                <td class="text-center">
                                    <a href="{{route('teacher.mycourses.show',$course_allocation->id)}}" class="link">
                                        {{$course_allocation->course->code}}
                                    </a>
                                </td>
                                <td>{{$course_allocation->course->name}} <span class="text-slate-400 text-sm">{{$course_allocation->course->lblCr()}}</span> </td>
                                <td>{{$course_allocation->slot_option->slot->cr}}</td>
                                <td>{{$course_allocation->section->title()}}</td>
                                <td class="text-center">{{$course_allocation->first_attempts()->count()}}</td>
                                <td class="text-center">{{$course_allocation->reappears()->count()}}</td>
                                <td class="text-center">{{$course_allocation->status()}}</td>
                                <td class="text-center">
                                    <a href="{{route('teacher.award',$course_allocation->id)}}" target="_blank" class="flex flex-col justify-center items-center">
                                        <i class="bi bi-printer text-blue-600"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection