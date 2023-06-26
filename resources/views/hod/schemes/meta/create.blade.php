@extends('layouts.hod')
@section('page-content')

<h1><a href="#">Study Scheme | Create Slot</a></h1>
<div class="bread-crumb">{{$scheme->program->name}} / schemes / {{$scheme->subtitle()}}</div>

<div class="flex flex-col md:w-3/5 m-auto text-center mt-12">
    <div class="flex items-center flex-row">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>


        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2 class="text-red-800">Read before you create!</h2>
            <p class="text-sm">Select one of the given course types and crdit hrs for the slot. Remember, <span class="uppercase underline underline-offset-4 text-orange-600">none of course type or credit hrs will be editable later.</span></p>
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
    <form action="{{route('scheme-meta.store')}}" method='post' class="flex flex-col w-full text-left mt-12">
        @csrf
        <input type="hidden" name="scheme_id" value="{{$scheme->id}}">
        <input type="hidden" name="semester_no" value="{{$semester_no}}">
        <input type="hidden" name="slot" value="{{$slot}}">

        <label for="" class="text-md font-bold">{{$scheme->program->name}}</label>
        <label for="" class="text-md font-semibold">Scheme: {{$scheme->subtitle()}}</label>
        <label for="" class="text-md font-semibold">Semester: {{$semester_no}}</label>
        <label for="" class="text-md font-bold">Slot : {{$slot}}</label>

        <div class="flex w-full items-center mt-3 space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class="">Choose course type </label>
                <select id="" name="course_type_id" class="input-indigo p-2">
                    @foreach($course_types as $course_type)
                    <option value="{{$course_type->id}}">{{$course_type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col w-24">
                <label for="" class="">Credit hrs. </label>
                <select id="" name="cr" class="input-indigo p-2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3" selected>3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn-indigo-rounded w-24">Create</button>
        </div>

    </form>

</div>

@endsection