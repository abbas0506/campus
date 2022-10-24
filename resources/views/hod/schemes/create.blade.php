@extends('layouts.hod')
@section('page-content')

<h1 class="mt-5">Schemes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Schemes / create
    </div>
</div>

<div class="flex flex-col md:w-3/5 m-auto text-center mt-12">

    <div class="flex">
        <a class="tab active ">Step 1 of 3</a>
        <a class="tab">Scheme</a>
        <a class="tab">Courses</a>
    </div>

    <div class="flex items-center flex-row mt-12">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2>Choose Semester (w.e.f) & Program</h2>
            <p class="text-sm">Before you proceed ahead to manipulate the classes, please tell us your target semester. If semesters' list is empty, please contact admin.</p>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert-danger mt-5">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route('schemes.store')}}" method='post' class="flex flex-col w-full text-left mt-12">
        @csrf
        <label for="">Choose Semester</label>
        <select id="" name="wef_semester_id" class="input-indigo p-2">
            @foreach($semesters as $semester)
            <option value="{{$semester->id}}">{{$semester->semester_type->name}} {{$semester->year}}</option>
            @endforeach
        </select>
        <label for="" class="mt-3">Choose Program</label>
        <select id="" name="program_id" class="input-indigo p-2">
            @foreach($programs as $program)
            <option value="{{$program->id}}">{{$program->name}} </option>
            @endforeach
        </select>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('schemes.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>

    </form>

</div>

@endsection