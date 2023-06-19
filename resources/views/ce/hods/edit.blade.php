@extends('layouts.controller')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">HODs<span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Edit</span> </h1>
    </div>

    @error('edit')
    <div class="text-red-400">Update error!</div>
    @enderror

    <form action="{{route('departments.update',$department)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <label for="">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter department name" value="{{$department->name}}">
        <button type="submit" class="btn-indigo mt-3">Update</button>
    </form>

</div>

@endsection