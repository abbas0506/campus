@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Courses</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('courses.index')}}"> Courses </a> / create
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

    <form action="{{route('courses.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf

        <div class="flex flex-row items-center">
            <!-- <label for="" class='mr-4 text-sm text-orange-600'>Category</label> -->
            <select id="" name="course_type_id" class="py-1 text-orange-500 outline-none">
                @foreach($course_types as $course_type)
                <option value="{{$course_type->id}}" class="text-gray-700">{{$course_type->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="" class="mt-4">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Object Oriented Programming">

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any, otherwise same as full name)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="OOP">
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Course Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="ZOOL-B-009">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value='4'>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value='100'>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('courses.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection