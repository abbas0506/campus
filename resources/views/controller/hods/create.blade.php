@extends('layouts.controller')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">HODs <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span> </h1>
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
    <form action="{{route('hods.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <label for="" class="text-sm text-gray-400">Select Department</label>
        <select name="department_id" id="" class="input-indigo p-2">
            @foreach($departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
            @endforeach
        </select>

        <label for="" class="text-sm text-gray-400 mt-3">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class="text-sm text-gray-400 mt-3">Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <button type="submit" class="btn-indigo mt-3">Save</button>
    </form>

</div>

@endsection