@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">

        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{url('hods')}}">
                HODs
            </a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Create</span>
        </h1>
    </div>
    <div class="mb-4 text-lg">{{$selected_department->name}}</div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif

    <form action="{{route('hods.update', $selected_department)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')

        <label for="" class="text-sm text-gray-400">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class="text-sm text-gray-400 mt-3">Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <label for="" class="text-sm text-gray-400 mt-3">CNIC <span class="ml-1">( xxxxx-xxxxxxx-x )</span></label>
        <input type="text" id='cnic' name='cnic' class="input-indigo" placeholder="Enter CNIC">

        <input type="text" name="department_id" value="{{$selected_department->id}}" hidden>
        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection