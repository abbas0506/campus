@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('students.index')}}">Students</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
    </div>

    <div class="text-xl text-slate-800">{{session('semester')->semester_type->name}} {{session('semester')->year}}</div>
    <div class="text-sm text-slate-500">{{session('program')->short}},
        @if(session('shift')=='M') Morning
        @elseif(session('shift')=='E') Evening
        @endif
        ({{session('section')->name}})
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('students.store')}}" method='post' class="flex flex-col w-full md:w-3/4 mt-4">
        @csrf
        <label for="" class="text-sm text-gray-400">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad">
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Gender</label>
                <select id="" name="gender" class="input-indigo p-2">
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="T">T</option>
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">CNIC</label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="xxxxx-xxxxxxx-x">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Phone</label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="xxxx-xxxxxxx">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk">
            </div>
        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Address <span class="text-sm">(optional)</span></label>
        <input type="text" id='' name='address' class="input-indigo" placeholder="University of Okara" value="University of Okara">

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection