@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>View Department</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.departments.index')}}">Departments</a>
        <div>/</div>
        <div>View</div>
    </div>


    <div class="relative flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-4 mt-4">
        <a href="{{route('admin.departments.edit',$department)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
        <div class="font-semibold text-slate-700 text-lg leading-relaxed">{{$department->name}}</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="relative border border-dashed bg-white p-4 mt-8">
        <a href="{{route('admin.headships.edit',$department)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
        <label for="" class="text-xs">HoD</label>
        @if($department->headship)
        <div class="text-md">{{$department->hod()->name}}</div>
        <div class="text-sm">{{$department->hod()->email}}</div>
        <div class="text-sm">{{$department->hod()->phone}} </div>
        @else
        <div class="text-sm">Not assigned</div>
        @endif
    </div>

</div>

@endsection