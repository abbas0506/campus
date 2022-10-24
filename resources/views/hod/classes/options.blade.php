@extends('layouts.hod')

@section('page-content')
<h1 class="mt-5">Classes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Classes / choose option
    </div>
</div>

<div class="flex flex-col md:w-3/5 m-auto text-center mt-12">

    <div class="flex">
        <a class="tab active ">Step 1/4</a>
        <a class="tab">Class</a>
        <a class="tab">Section</a>
        <a class="tab">Students</a>
    </div>

    <div class="flex items-center flex-row mt-12">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2>Choose Current Semester</h2>
            <p class="text-sm">Before you proceed ahead, please tell us your desired semester. If the semester is not listed, please contact admin.</p>
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


    <form action="{{route('class-options.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf
        <select id="" name="semester_id" class="input-indigo p-2 mt-3">
            @foreach($semesters as $semester)
            <option value="{{$semester->id}}">{{$semester->semester_type->name}} {{$semester->year}}</option>
            @endforeach
        </select>

        <div class="flex w-full md:space-x-4">
            <a href="{{url('hod')}}" class="flex flex-1 justify-center btn-indigo mt-8">Cancel</a>
            <button type="submit" class="flex flex-1 justify-center btn-indigo mt-8">Next</button>
        </div>

    </form>

</div>

@endsection