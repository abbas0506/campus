@extends('layouts.hod')
@section('page-content')

<h1><a href="#">Study Scheme | Create Slot</a></h1>
<div class="bread-crumb">{{$scheme->program->name}} / schemes / {{$scheme->subtitle()}}</div>

<div class="flex flex-col md:w-4/5 m-auto mt-12">
    <div class="flex items-center flex-row">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2 class="text-red-800 animate-pulse">Remember!</h2>
            <p class="text-sm underline underline-offset-4 text-orange-600">Crdit hrs will not be editable later.</p>
        </div>
    </div>

    @php
    $roman = config('global.romans');
    @endphp
    <div class="flex items-center mt-8">
        <h2>{{$scheme->program->short}}</h2>
        <span class="chevron-right mx-1"></span>
        <a href="{{route('schemes.show', $scheme)}}" class="flex items-center text-blue-600 link">
            {{$scheme->subtitle()}}
            ({{$roman[$semester_no-1]}})
        </a>
    </div>
    <h2 class="mt-2">Slot # {{$slot_no}}</h2>

    @if ($errors->any())
    <div class="alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @php
    $roman = config('global.romans');
    @endphp


    <form action="{{route('slots.store')}}" method='post' class="flex flex-col w-full text-left mt-6">
        @csrf

        <input type="hidden" name="scheme_id" value="{{$scheme->id}}">
        <input type="hidden" name="semester_no" value="{{$semester_no}}">
        <input type="hidden" name="slot_no" value="{{$slot_no}}">

        <label for="" class="mt-3">Credit hrs. </label>
        <select id="" name="cr" class="custom-input p-2">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>

        <label for="" class='mt-3 font-semibold'>Course Type (atleast one)</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-2 text-sm mt-3">
            @foreach($course_types as $course_type)
            <div class="flex space-x-2 items-center awesome-chk">
                <input type="checkbox" id='chk-{{$course_type->id}}' name='course_type_id[]' value="{{$course_type->id}}" class="chk hidden">
                <label for="chk-{{$course_type->id}}">
                    <!-- bullet from app.css -->
                    <span></span>
                </label>
                <div>{{$course_type->name}}</div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn-indigo-rounded mt-4 w-24">Create</button>

    </form>

</div>

@endsection