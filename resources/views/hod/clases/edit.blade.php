@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Edit Class</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.clases.index')}}">Current Classes</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">
        <div class="flex flex-col md:flex-row md:items-center gap-x-4">
            <i class="bi-info-circle text-2xl text-indigo-600"></i>
            <div class="flex-grow text-left sm:mt-0">
                <h2>Please note</h2>
                <ul class="text-sm">
                    <li>First semester means the very first semester (when class started on).</li>
                    <li>If study scheme is missing, it can be defined using one time activity tab</li>
                </ul>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <h1 class='text-red-600 mt-8'>{{$clas->program->short}} <i class="bx bx-chevron-right"></i>Edit Class</h1>

        <form action="{{route('hod.clases.update',$clas)}}" method='post' class="mt-8" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <input type="text" name="program_id" value="{{$clas->program->id}}" hidden>

            <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-4">
                <div class="w-full">
                    <label>First Semester (class started on)</label>
                    <select id='first_semester_id' name="first_semester_id" class="custom-input">
                        @foreach($semesters as $semester)
                        <option value="{{$semester->id}}" @selected($semester->id==$clas->first_semester_id)>{{$semester->short()}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Choose Shift</label>
                    <select name="shift_id" class="custom-input">
                        @foreach($shifts as $shift)
                        <option value="{{$shift->id}}" @selected($shift->id==$clas->shift_id)>{{$shift->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Study Scheme for this class?</label>
                    <select id='scheme_id' name="scheme_id" class="custom-input">
                        @foreach($clas->program->schemes as $scheme)
                        <option value="{{$scheme->id}}" @selected($scheme->id==$clas->scheme_id)>{{$scheme->subtitle()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-indigo-rounded mt-6">Update Now</button>

        </form>

    </div>
</div>

@endsection