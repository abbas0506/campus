@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Teachers</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Teachers / create
    </div>
</div>

<div class="container md:w-3/4 mx-auto px-5">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('teachers.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf

        <div class="flex flex-col md:flex-row">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Teacher Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Dr. Sajjad Ahmad">
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Department</label>
                <select name="department_id" id='' class="input-indigo p-2">
                    <option value="{{session('department_id')}}">{{session('department')->name}}</option>
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span class="text-xs">: 3530112345671</span></label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="Without dashes">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Phone <span class="text-xs">: 03001234567</span></label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="Without dash">
            </div>
        </div>
        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('teachers.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>


    </form>

</div>

@endsection