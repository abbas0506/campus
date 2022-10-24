@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('users.index')}}">Users</a>
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

    <form action="{{route('users.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <label for="">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class='mt-3'>Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <label for="" class='mt-3'>CNIC <span class="ml-1">( xxxxx-xxxxxxx-x )</span></label>
        <input type="text" id='cnic' name='cnic' class="input-indigo" placeholder="Enter CNIC">

        <label for="">Filter</label>
        <select name="department_id" id='' class="input-indigo p-2">
            <option value="">Click here</option>
            @foreach($departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection