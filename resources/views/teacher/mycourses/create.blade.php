@extends('layouts.hod')
@section('page-content')
<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <div class="flex items-center my-12">
        <h1 class="text-indigo-500 text-xl">
            <a href="{{route('teachers.index')}}">Teachers</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('teachers.store')}}" method='post' class="flex flex-col w-full">
        @csrf

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Full Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Dr. Sajjad Ahmad">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Designation</label>
                <select id="" name="designation_id" class="input-indigo p-2">
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span class="text-xs">: 3530112345671</span></label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="Without dashes">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Phone <span class="text-xs">: 03001234567</span></label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="Without dash">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk">
            </div>
        </div>

        <button type="submit" class="btn-indigo mt-8">Save</button>
    </form>

</div>

@endsection