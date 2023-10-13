@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Semester Plan</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Semester Plan</div>
        <div>/</div>
        <div>Classes</div>
    </div>

    <!-- help -->
    <div class="flex flex-col md:flex-row md:items-center gap-x-4 mt-8">
        <i class="bi-info-circle text-2xl text-indigo-600"></i>
        <div class="flex-grow text-left sm:mt-0">
            <ul class="text-sm text-slate-600">
                <li>Only non-empty sections are visible here</li>
                <li>If some section is missing on this page, it might have no student</li>
            </ul>
        </div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <!-- records found -->
    <div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$programs->count()}} programs found</div>

    <!-- Programs and classes -->
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
                            @if($section->students()->exists())
                            <a href="{{route('hod.semester-plan.show',$section)}}" class='pallet-teal'>
                                {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                            </a>
                            @endif
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