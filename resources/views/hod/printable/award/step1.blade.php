@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Award List</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('hod/printable')}}">Print Options</a>
        <div>/</div>
        <div>Award</div>
    </div>
    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle pr-2 text-2xl"></i>
        <ul class="text-xs">
            <li>Click on any program, sections will appear</li>
            <li>Click on any section to see or print award lists of the section</li>
        </ul>
    </div>
    <!-- records found -->
    <div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$programs->count()}} programs found</div>
    <div class="flex flex-col accordion">
        @foreach($programs->sortBy('level') as $program)
        <div class="collapsible">
            <div class="head">
                <h2 class="flex items-center space-x-4">
                    {{$program->short}}
                    <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->active()->count()}}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                @foreach($program->clases()->active()->get() as $clas)
                <div class="grid grid-cols-1 md:grid-cols-2 w-full text-sm gap-4 border-b md:divide-x divide-slate-200 p-2">
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
                            <a href="{{route('hod.award.step2',$section)}}" class='pallet-teal'>
                                {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection