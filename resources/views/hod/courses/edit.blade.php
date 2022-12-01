@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Courses</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('courses.index')}}"> Courses </a> / edit
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

    <form action="{{route('courses.update',$course)}}" method='post' class="flex flex-col w-full mt-12">
        @csrf
        @method('PATCH')
        <div class="flex flex-col w-48">
            <label for="" class="">Category</label>
            <select id="" name="course_type_id" class="input-indigo p-2">
                @foreach($course_types as $course_type)
                <option value="{{$course_type->id}}" @if($course_type->id==$course->course_type_id)selected @endif>{{$course_type->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="" class="mt-3">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Software Engineering" value="{{$course->name}}">

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: SE" value="{{$course->short}}">
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Course Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="ZOOL-B-009" value="{{$course->code}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value="{{$course->credit_hrs_theory}}">
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value="{{$course->max_marks_theory}}" min=0>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->credit_hrs_practical}}" min=0>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->max_marks_practical}}" min=0>
            </div>

        </div>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('courses.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Update</button>
        </div>
    </form>

</div>

@endsection