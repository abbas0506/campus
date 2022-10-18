@extends('layouts.hod')

@section('page-content')


<div class="flex flex-col md:w-3/5 m-auto text-center mt-16">

    <div class="flex mx-auto flex-wrap mb-20 w-full">
        <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium bg-gray-100 inline-flex items-center leading-none border-indigo-500 text-indigo-500 tracking-wider rounded-t">
            STEP 1
        </a>
        <a class="sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium inline-flex items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider">
            STEP 2
        </a>
    </div>

    <div class="flex items-center mx-auto border-b pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
        <div class="sm:w-32 sm:h-32 h-20 w-20 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="sm:w-16 sm:h-16 w-10 h-10" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
            </svg>
        </div>
        <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
            <h2 class="text-gray-900 text-lg title-font font-bold mb-2">Choose Semester</h2>
            <p class="leading-relaxed text-base">Before you proceed ahead to manipulate the classes, please tell us your target semester. If semesters' list is empty, please contact admin.</p>
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

    <form action="{{route('class-options.store')}}" method='post' class="flex flex-col w-full">
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