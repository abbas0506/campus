@extends('layouts.controller')
@section('page-content')
<div class="flex flex-col justify-center items-center mt-40">

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif

    <form action="{{route('transcripts.store')}}" class="flex flex-col w-3/4" method="post">
        @csrf
        <div class="text-2xl text-indigo-500">Student Transcript</div>
        <input type="text" name='rollno' class="input-indigo py-2 px-4 mt-3" placeholder="Enter roll no." id='rollno'>
        <button type='submit' class="btn-indigo p-2 mt-4" onclick="serachByRollNo()">Search</button>

        @if($student)
        <a href="{{route('transcripts.show', $student)}}" class="flex items-center bg-green-100 relative mt-8 ml-4 p-2">
            <div class="w-16 h-16 absolute -left-4 rounded-full flex items-center justify-center bg-teal-500 text-yellow-400 ring-4 ring-slate-50">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>

            </div>
            <div class="flex flex-col pl-12 ">
                <div class="font-bold">{{$student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father}}</div>
                <div class="text-sm text-gray-500">{{$student->section->title()}}</div>
            </div>
        </a>
        @elseif($searched)
        <div class="alert-danger mt-4 text-center">
            No record exists
        </div>
        @endif

    </form>
</div>

@endsection