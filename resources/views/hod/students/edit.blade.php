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
        <label for="" class="text-sm text-gray-400">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$student->user->name}}">
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Gender</label>
                <select id="" name="gender" class="input-indigo p-2">
                    <option value="M" @if($student->gender=='M') selected @endif>M</option>
                    <option value="F" @if($student->gender=='F') selected @endif>F</option>
                    <option value="T" @if($student->gender=='T') selected @endif>T</option>
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">CNIC</label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="xxxxx-xxxxxxx-x" value="{{$student->cnic}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Phone</label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="xxxx-xxxxxxx" value="{{$student->phone}}">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk" value="{{$student->user->email}}">
            </div>
        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Address <span class="text-sm">(optional)</span></label>
        <input type="text" id='' name='address' class="input-indigo" placeholder="University of Okara" value="University of Okara" value="{{$student->address}}">


        <button type="submit" class="btn-indigo mt-4">Update</button>
    </form>

</div>

@endsection