@extends('layouts.admin')
@section('page-content')
<div class="flex">
    <a href="{{route('departments.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">{{$department->name}}</div>
    @if($department->headship)
    <div class="text-md">{{$department->hod()->name}}</div>
    <div class="text-sm">{{$department->hod()->email}}</div>
    <div class="text-sm">{{$department->hod()->phone}} </div>
    @else
    <div class="text-sm">HoD details not available</div>
    @endif
</div>

<div class="container w-full mx-auto mt-8">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="text-xl text-teal-700"></div>

    <div class="border-b py-4"></div>
    <div class="text-md font-bold mt-8">Programs <span class="text-xs">({{$department->programs->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->programs->sortBy('name') as $program)
        <div>&#9656; {{$program->short}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Courses <span class="text-xs">({{$department->courses->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->courses->sortBy('name') as $course)
        <div>&#9656; {{$course->short}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Teachers <span class="text-xs">({{$department->teachers()->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->teachers()->sortBy('name') as $teacher)
        <div>&#9656; {{$teacher->name}}</div>
        @endforeach
    </div>

    <div class="text-md font-bold mt-3">Classes <span class="text-xs">({{$department->clases()->count()}})</span></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 text-sm mt-3">
        @foreach($department->clases()->sortBy('name') as $clas)
        <div class="flex text-md">&#9656; {{$clas->short()}}
            &#8674;
            @foreach($clas->sections as $section)
            {{$section->name}}
            @endforeach
        </div>

        @endforeach
    </div>

</div>

@endsection