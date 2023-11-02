@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Edit Department</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.departments.index')}}">Departments</a>
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

        <div class="flex flex-col justify-center items-center">
            <form action="{{route('admin.departments.update',$department)}}" method='post' class="flex flex-col w-full">
                @csrf
                @method('PATCH')
                <label for="">Full Name</label>
                <input type="text" id='' name='name' class="custom-input mt-2" placeholder="Enter department name" value="{{$department->name}}">

                <label for="" class='mt-4'>Display Name <span class="text-sm text-orange-700">(to be displayed on final degree)</span></label>
                <input type="text" id='' name='title' class="custom-input mt-2" placeholder="Department of Chemistry" value="{{$department->title}}">

                <div class="flex items-center justify-end mt-4 py-2">
                    <button type="submit" class="btn-indigo-rounded">Update</button>
                </div>
            </form>

        </div>

        @endsection