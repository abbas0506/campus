@extends('layouts.hod')
@section('page-content')
<div class="container px-8">

    <div class="py-10">
        <h1 class="text-indigo-500 text-2xl font-medium text-center">Course Allocation | {{$program->short}}
            <h1>
    </div>

    <div class=" flex flex-row items-center justify-center text-base bg-blue-100 text-blue-800 rounded p-3 mb-8 md:w-4/5 mx-auto">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
        </svg>
        If desired semester is not listed, contact admin !
    </div>
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 md:w-4/5 mx-auto">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- possible schemes for the selected subject -->
    <form action="{{route('course-allocations.store')}}" method='post' class="flex flex-col w-full md:4/5">
        @csrf
        <div class="flex flex-col justify-center md:w-4/5 mx-auto mb-6">
            <h2 class="text-lg text-gray-900 font-medium title-font mb-3">Scheme to follow during semester</h2>
            <label for="" class="text-sm text-gray-400">Select a scheme</label>
            <select id="" name="scheme_id" class="input-indigo p-2">
                @foreach($program->schemes as $scheme)
                <option value="{{$scheme->id}}">Scheme {{$scheme->semester->year}}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col md:flex-row md:w-4/5 mx-auto">
            <div class="md:w-1/2 border border-gray-200 rounded-lg p-6">
                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <h2 class="text-lg text-gray-900 font-medium title-font mb-3">Semester</h2>
                    <label for="" class="text-sm text-gray-400">Select</label>
                    <select id="" name="semester_id" class="input-indigo p-2">
                        @foreach($semesters as $semester)
                        <option value="{{$semester->id}}">{{$semester->semester_type->name}} {{$semester->year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="md:w-1/2 border border-gray-200 rounded-lg p-6 md:ml-3">
                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>

                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Shift</h2>
                    <div class="flex item-cetner mt-3">
                        <input type="radio" name='shift_id' value="M" checked>
                        <label for="" class="ml-3">Mornig</label>
                    </div>
                    <div class="flex item-cetner mt-2">
                        <input type="radio" name='shift_id' value="E">
                        <label for="" class="ml-3">Evening</label>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 border border-gray-200 rounded-lg p-6 md:ml-3">
                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <h2 class="text-lg text-gray-900 font-medium title-font mb-3">Section</h2>
                    <label for="" class="text-sm text-gray-400">Select</label>
                    <select id="" name="section_id" class="input-indigo p-2">
                        @foreach($sections as $section)
                        <option value="{{$section->id}}">{{$section->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="flex justify-center mt-8">
            <button type="submit" class="btn-indigo">Start Course Allocation</button>
        </div>

    </form>
</div>

@endsection