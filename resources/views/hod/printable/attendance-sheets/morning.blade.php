@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Attendance Sheets</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{url('hod/printable')}}">Print Options</a>
        <div>/</div>
        <div>Attendance Sheets</div>
    </div>
    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle pr-2 text-2xl"></i>
        <ul class="text-xs">
            <li>Click on any program, sections will appear</li>
            <li>Click on mid or final for attendance sheets</li>
        </ul>
    </div>

    <div class="flex flex-wrap items-center justify-between w-full mt-8 gap-y-4">
        <div class="flex items-center space-x-4 text-slate-600">
            <div class="tab active">Morning ({{$department->clases()->morning()->active()->get()->count()}})</div>
            <a href="{{route('hod.attendance-sheets.index',2)}}" class="tab">Self Support ({{$department->clases()->selfSupport()->active()->get()->count()}})</a>
        </div>
    </div>
    <!-- <div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$programs->count()}} programs found</div> -->
    <div class="flex flex-col accordion mt-8">
        @foreach($programs->sortBy('level') as $program)
        <!-- show only those programs which has some classes -->
        @if($program->clases()->active()->morning()->count()>0)
        <div class="collapsible">
            <div class="head">
                <h2 class="flex items-center space-x-4">
                    {{$program->short}}
                    <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->morning()->active()->count()}}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">

                @foreach($program->clases()->morning()->active()->get() as $clas)
                <div class="grid grid-cols-1 md:grid-cols-3 w-full text-sm gap-4 border-b md:divide-x divide-slate-200 p-2">
                    <div>
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="text-sm">{{$clas->title()}}</div>
                            <div class="flex items-center space-x-2">
                                <div class="text-xs text-slate-400">
                                    <i class="bi bi-person"></i> ({{$clas->strength()}})
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:pl-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach($clas->sections as $section)
                            <a href="{{route('hod.award.courses',$section)}}" class='pallet-teal'>
                                {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-center items-center space-x-4">
                        <a href="{{route('hod.attendance-sheets.pdf',[$clas,1])}}" target='_blank' class="btn-sky text-xs">Mid</i></a>
                        <a href="{{route('hod.attendance-sheets.pdf',[$clas,2])}}" target='_blank' class="btn-orange text-xs">Final</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection