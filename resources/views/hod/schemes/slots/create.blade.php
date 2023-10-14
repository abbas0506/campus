@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Create New Slot</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.schemes.index')}}">Schemes</a>
        <div>/</div>
        <a href="{{route('hod.schemes.show', $scheme)}}">{{$scheme->subtitle()}}</a>
        <div>/</div>
        <div>New Slot</div>
    </div>

    @php
    $roman = config('global.romans');
    @endphp


    <h2 class="mt-12">{{$scheme->program->short}} / {{$scheme->subtitle()}}({{$roman[$semester_no-1]}})</h2>
    <h1 class=" text-red-600 mt-1">Slot # {{$slot_no}}</h1>
    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle text-2xl"></i>
        <ul class="text-sm ml-4">
            <li>Please associate exact course types to this slot as per concerned scheme</li>
            <li>Be carefull while selecting credit hrs for the slot as it will not be editable later</li>
        </ul>
    </div>

    <div class="mt-8">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <form action="{{route('hod.slots.store')}}" method='post' class="flex flex-col w-full text-left mt-6">
            @csrf

            <input type="hidden" name="scheme_id" value="{{$scheme->id}}">
            <input type="hidden" name="semester_no" value="{{$semester_no}}">
            <input type="hidden" name="slot_no" value="{{$slot_no}}">

            <label for="" class="mt-3">Credit hrs. </label>
            <select id="" name="cr" class="custom-input md:w-1/3 p-2">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3" selected>3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>

            <label for="" class='mt-3 font-semibold'>Note: You may associate multiple course types with current slot. </label>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-y-2 text-sm mt-3">
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

            <button type="submit" class="btn-teal rounded mt-8 w-24">Create</button>

        </form>

    </div>

    @endsection