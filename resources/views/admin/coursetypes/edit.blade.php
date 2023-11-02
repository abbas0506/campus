@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Edit Course Type</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.coursetypes.index')}}">Course Tyeps</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-12">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <form action="{{route('admin.coursetypes.update', $coursetype)}}" method='post' class="flex flex-col w-full">
            @csrf
            @method('PATCH')
            <label for="">Course Type</label>
            <input type="text" id='' name='name' class="custom-input mt-2" placeholder="Course type name" value="{{$coursetype->name}}">

            <div class="flex items-center justify-end mt-4 py-2">
                <button type="submit" class="btn-indigo-rounded">Update</button>
            </div>
        </form>

    </div>

    @endsection