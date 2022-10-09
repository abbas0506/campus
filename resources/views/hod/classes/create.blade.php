@extends('layouts.hod')
@section('page-content')
<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('classes.index')}}">Classes</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="alert-danger text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex text-slate-600 text-base mb-4">
        {{$semester->semester_type->name}} {{$semester->year}}
        <a href="{{url('class-options')}}" class="ml-4 text-indigo-600 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </a>
    </div>
    <form action="{{route('classes.store')}}" method='post' class="flex flex-col w-full">
        @csrf
        <!-- <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Shift</h2> -->
        <div class="flex item-cetner mt-3">
            <input type="radio" name='shift' value="M" checked>
            <label for="" class="ml-3">Mornig</label>
        </div>
        <div class="flex item-cetner mt-2">
            <input type="radio" name='shift' value="E">
            <label for="" class="ml-3">Evening</label>
        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Program</label>
        <select id="" name="program_id" class="input-indigo p-2">
            <option value="">Select a program</option>
            @foreach($programs->sortBy('name') as $program)
            <option value="{{$program->id}}">{{$program->name}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection