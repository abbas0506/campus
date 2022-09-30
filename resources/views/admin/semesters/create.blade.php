@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('semesters.index')}}">Calendar</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('semesters.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col md:w-48 mt-3">
                <label for="" class="text-sm text-gray-400">Semester Type</label>
                <select name="semester_type_id" id="" class="input-indigo p-2">
                    @foreach($semester_types as $semester_type)
                    <option value="{{$semester_type->id}}">{{$semester_type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col mx-0 md:ml-4 mt-3">
                <label for="" class="text-sm text-gray-400">Year </label>
                <input type="number" id='' name='year' class="input-indigo" placeholder="Year" value="{{now()->year}}" min=2014>
            </div>
            <div class="flex flex-col flex-1 mt-3 md:ml-4">
                <label for="" class="text-sm text-gray-400">Allow Edit Till (mm/dd/yyyy) </label>
                <input type="date" id='' name='edit_till' class="input-indigo" placeholder="Allow edit till date">
            </div>
        </div>
        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection