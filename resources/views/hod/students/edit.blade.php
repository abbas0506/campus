@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('students.index')}}">Students</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Edit</span>
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

    <form action="{{route('students.update',$student)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <label for="">Gender</label>
        <select id="" name="gender" class="input-indigo p-2 w-32">
            <option value="M" @if($student->gender=='M') selected @endif>M</option>
            <option value="F" @if($student->gender=='F') selected @endif>F</option>
        </select>

        <label for="" class='mt-3'>Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$student->name}}">

        <label for="" class='mt-3'>Father</label>
        <input type="text" id='' name='father' class="input-indigo" placeholder="father name" value="{{$student->father}}">

        <button type="submit" class="btn-indigo mt-4">Update</button>
    </form>

</div>

@endsection