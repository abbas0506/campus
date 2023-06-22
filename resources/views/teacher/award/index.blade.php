@extends('layouts.teacher')
@section('page-content')

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-4">
    <i class="bx bx-printer text-[40px] text-slate-600"></i>
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">Award Lists / Assessment Sheets</div>
    <div class="text-slate-700">( {{session('semester')}} )</div>
</div>

<div class="w-full mt-12">
    <!-- sort courses section wise -->
    @foreach($course_allocations as $course_allocation)
    <div class="flex flex-row justify-between p-2  even:bg-slate-100 border-b border-dashed">
        <div class="flex flex-col flex-1 py-1">
            <div class="">{{$course_allocation->course->name}}</div>
            <div class="text-xs">{{$course_allocation->section->title()}}</div>
        </div>
        <div class="flex items-center text-slate-600 text-xs mr-5">
            <i class="bx bx-group bx-xs text-slate-600"></i>
            <div class="xs">{{$course_allocation->first_attempts->count()+$course_allocation->reappears->count()}}</div>
        </div>
        <a href="{{route('teacher.award',$course_allocation->id)}}" target="_blank" class="flex flex-col justify-center items-center">
            <i class="bx bx-printer text-blue-600"></i>
        </a>
    </div>

    @endforeach
</div>

<!-- <div class="relative flex flex-col justify-between items-center border p-4 bg-white hover:bg-slate-100">
        <div class="absolute right-0 top-0 bg-emerald-100 text-emerald-600 px-2 py-0 text-sm">
            
        </div>
        <a href="{{route('teacher.award',$course_allocation->id)}}" target="_blank" class="flex flex-col justify-center items-center">
            <i class="bx bx-printer bx-sm text-slate-600"></i>
            <div class="font-semibold text-teal-800 mt-3 w-full text-center">
                {{$course_allocation->course->name}}
            </div>
            <div class="text-xs mt-2 mb-3">{{$course_allocation->section->title()}}</div>
        </a>

    </div> -->

</div>
@endsection