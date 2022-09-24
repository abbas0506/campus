@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('departments.index')}}">Departments</a>
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

    <form action="{{route('departments.update',$department)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <label for="" class="text-sm text-gray-400">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Enter department name" value="{{$department->name}}">

        <label for="" class="text-sm text-gray-400 mt-3">Display Name <span class="text-sm">(to be displayed on final degree)</span></label>
        <input type="text" id='' name='title' class="input-indigo" placeholder="Department of Chemistry" value="{{$department->title}}">

        <button type="submit" class="btn-indigo mt-3">Update</button>
    </form>

</div>

@endsection