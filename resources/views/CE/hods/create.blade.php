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

        <label for="" class="text-sm text-gray-400 mt-3">Choose from existing</label>
        <select name="user_id" id="" class="input-indigo p-2">
            <option value="">Select a person</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
        <div class="flex items-center text-gray-600 border-b border-t border-dashed border-indigo-800 bg-indigo-100 mt-12 mb-5 p-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-6 6m0 0l-6-6m6 6V9a6 6 0 0112 0v3" />
            </svg>
            Add New <span class="text-sm ml-4">(only if the person does not exist in above list)</span>
        </div>

        <label for="" class="text-sm text-gray-400">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class="text-sm text-gray-400 mt-3">Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection