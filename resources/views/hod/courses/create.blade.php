@extends('layouts.hod')
@section('page-content')

<div class="container md:w-3/4 mx-auto px-5 md:px-0">

    <div class="flex items-center justify-between">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('courses.index')}}">Courses</a>
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

    <form action="{{route('courses.store')}}" method='post' class="flex flex-col w-full">
        @csrf

        <div class="flex flex-col w-48">
            <label for="" class="text-sm mt-3 text-gray-400">Category</label>
            <select id="" name="course_type_id" class="input-indigo p-2">
                @foreach($course_types as $course_type)
                <option value="{{$course_type->id}}">{{$course_type->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="" class="text-sm text-gray-400 mt-4">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Object Oriented Programming">

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Short Name <span class="text-sm">(if any, otherwise same as full name)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="OOP">
            </div>
            <div class="flex flex-col">
                <label for="" class="text-sm text-gray-400 mt-3">Course Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="ZOOL-B-009">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1 w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value='4'>
            </div>
            <div class="flex flex-col w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value='100'>
            </div>
            <div class="flex flex-col w-40 flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>
            <div class="flex flex-col w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>

        </div>
        <input type="text" name='department_id' value="{{Auth::user()->teacher->department_id}}" hidden>
        <button type="submit" class="btn-indigo mt-8">Save</button>
    </form>

</div>

@endsection