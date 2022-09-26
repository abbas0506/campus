@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('courses.index')}}">Courses</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
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

    <form action="{{route('courses.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <label for="" class="text-sm text-gray-400">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Software Engineering">

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: SE">
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Course Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="ZOOL-B-009">
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Course Type</label>
                <select id="" name="department_id" class="input-indigo p-2">
                    @foreach($course_types as $course_type)
                    <option value="{{$course_type->id}}">{{$course_type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value='4'>
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks" class="input-indigo p-1 pl-2" placeholder="Marks" value='100'>
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>
        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Department</label>
        <select id="" name="department_id" class="input-indigo p-2">
            <option value="">Select a department</option>
            @foreach($departments->sortBy('name') as $department)
            <option value="{{$department->id}}" @if($department->id==Auth::user()->employee->department_id) selected @endif>{{$department->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection