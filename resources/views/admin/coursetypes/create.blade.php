@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>New Course Type</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.coursetypes.index')}}">Course Tyeps</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-12">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('admin.coursetypes.store')}}" method='post' class="flex flex-col w-full">
            @csrf
            <label for="">Course Type</label>
            <input type="text" id='' name='name' class="custom-input mt-2" placeholder="Course type name">

            <div class="flex items-center justify-end mt-4 py-2">
                <button type="submit" class="btn-indigo-rounded">Save</button>
            </div>
        </form>

    </div>

    @endsection