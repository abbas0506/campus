@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Schemes</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('schemes.index')}}">Program & Schemes</a>
        <div>/</div>
        <div>New</div>
    </div>


    <div class="w-full md:w-3/4 mx-auto mt-12">
        <!-- help -->
        <div class="flex flex-row items-center gap-x-4">
            <i class="bi-info-circle text-2xl pr-4"></i>
            <div class="flex-grow text-left sm:mt-0">
                <ul class="text-sm">
                    <li>If semesters' list is empty, please contact admin.</li>
                </ul>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('schemes.store')}}" method='post' class="flex flex-col w-full text-left mt-8">
            @csrf
            <h1 class="text-red-600">{{$program->short}}<span class="text-sm text-red-700 ml-2 font-thin">(program for which scheme is being defined)</span></h1>
            <input id="" name="program_id" value="{{$program->id}}" class="hidden">

            <label for="" class="mt-3">This scheme will be effective from <span class='text-xs text-slate-600'>(S=Spring, F=Fall)</span></label>
            <select id="" name="wef_semester_id" class="custom-input p-2">
                @foreach($semesters as $semester)
                <option value="{{$semester->id}}">{{$semester->short()}}</option>
                @endforeach
            </select>


            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2 w-24">Next</button>
            </div>

        </form>
    </div>

</div>

@endsection