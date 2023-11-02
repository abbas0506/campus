@extends('layouts.admin')
@section('page-content')

<div class="container">
    <h2>New Department</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.departments.index')}}">Departments</a>
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

        <form action="{{route('admin.departments.store')}}" method='post' class="flex flex-col w-full mt-8">
            @csrf
            <label for="">Full Name</label>
            <input type="text" id='' name='name' class="custom-input" placeholder="Department of Analytical Chemistry">

            <label for="" class='mt-3'>Display Name <span class="text-sm text-orange-700">(to be displayed on final degree)</span></label>
            <input type="text" id='' name='title' class="custom-input" placeholder="Department of Chemistry">

            <div class="flex items-center justify-end mt-4 py-2">
                <button type="submit" class="btn-indigo-rounded">Save</button>
            </div>
        </form>

    </div>
</div>

@endsection