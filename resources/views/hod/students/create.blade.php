@extends('layouts.hod')
@section('page-content')
<div class="container md:w-4/5 mx-auto px-5 md:px-0">
    <div class="flex items-center ">
        <h1 class="text-indigo-500 text-xl my-12 mb-8">
            <a href="{{route('students.index')}}">Students</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
    </div>

    <div class="flex text-slate-600 bg-slate-100 rounded p-2 text-sm mb-4">
        {{$section->title()}}
        <a href="{{url('classes')}}" class="ml-4 text-indigo-600 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </a>
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

    <form action="{{route('students.store')}}" method='post' class="flex flex-col w-full">
        @csrf

        <!-- <label for="">Gender</label>
        <select id="" name="gender" class="input-indigo p-2 w-32">
            <option value="M">M</option>
            <option value="F">F</option>
        </select> -->
        <div class="flex space-x-4">
            <label for="">Gender</label>
            <input type="radio" name="gender" id="" checked> <span class="ml-3">Male</span>
            <input type="radio" name="gender" id=""> <span class="ml-3">Female</span>
        </div>

        <label for="" class='mt-3'>Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad">

        <label for="" class='mt-3'>Father</label>
        <input type="text" id='' name='father' class="input-indigo" placeholder="father name">
        <div class="flex md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Roll No</label>
                <input type="text" name="rollno" class="input-indigo" placeholder="Roll No.">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Reg. No</label>
                <input type="text" name="regno" class="input-indigo" placeholder="Registration No.">
            </div>
        </div>
        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection