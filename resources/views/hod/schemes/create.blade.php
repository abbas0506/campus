@extends('layouts.hod')
@section('page-content')

<h1 class="mt-12"><a href="{{route('schemes.index')}}">Schemes</a></h1>
<div class="bread-crumb">{{$program->name}} / New scheme</div>

<div class="flex flex-col md:w-3/5 m-auto text-center mt-12">
    <div class="flex items-center flex-row">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>


        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2>Choose Semester (w.e.f)</h2>
            <p class="text-sm">This scheme will be effective from the semster, you choose for this purpose. If semesters' list is empty, please contact admin.</p>
            <p class="text-sm"></p>
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
        <label for="" class="text-md font-bold">{{$program->name}}<span class="text-sm text-red-700 ml-2 font-thin">(program for which scheme is being defined)</span></label>
        <input id="" name="program_id" value="{{$program->id}}" class="hidden">

        <label for="" class="mt-3">This scheme will be effective from</label>
        <select id="" name="wef_semester_id" class="input-indigo p-2">
            @foreach($semesters as $semester)
            <option value="{{$semester->id}}">{{$semester->semester_type->name}} {{$semester->year}}</option>
            @endforeach
        </select>


        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Next</button>
        </div>

    </form>

</div>

@endsection