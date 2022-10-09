@extends('layouts.hod')
@section('page-content')

<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <form action="{{route('courses.update',$course)}}" method='post' class="flex flex-col w-full">
        @csrf
        @method('PATCH')
        <div class="flex items-center justify-between">
            <h1 class="text-indigo-500 text-xl py-10">
                <a href="{{route('courses.index')}}">Courses</a>
                <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Edit</span>
            </h1>
            <div class="flex flex-col">
                <label for="" class="text-sm mt-3 text-orange-600">Category</label>
                <select id="" name="course_type_id" class="input-indigo p-2">
                    @foreach($course_types as $course_type)
                    <option value="{{$course_type->id}}" @if($course_type->id==$course->course_type_id)selected @endif>{{$course_type->name}}</option>
                    @endforeach
                </select>
            </div>

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

        <label for="" class="text-sm text-gray-400">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Software Engineering" value="{{$course->name}}">

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: SE" value="{{$course->short}}">
            </div>
            <div class="flex flex-col">
                <label for="" class="text-sm text-gray-400 mt-3">Course Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="ZOOL-B-009" value="{{$course->code}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1 w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value='4' value="{{$course->credit_hrs_theory}}">
            </div>
            <div class="flex flex-col w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value='100' value="{{$course->max_marks_theory}}" value="{{$course->credit_hrs_practical}}" min=0>
            </div>
            <div class="flex flex-col w-40 flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->credit_hrs_practical}}" min=0>
            </div>
            <div class="flex flex-col w-40">
                <label for="" class="text-sm text-gray-400 mt-3">Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->max_marks_practical}}" min=0>
            </div>

        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Select Department</label>
        <select id="" name="department_id" class="input-indigo p-2">
            <option value="">Select a department</option>
            @foreach($departments->sortBy('name') as $department)
            <option value="{{$department->id}}" @if($department->id==$course->department_id) selected @endif>{{$department->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-indigo mt-8">Save</button>
    </form>

</div>

@endsection