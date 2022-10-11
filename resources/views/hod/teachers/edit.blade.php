@extends('layouts.hod')
@section('page-content')
<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <div class="flex items-center my-12">
        <h1 class="text-indigo-500 text-xl">
            <a href="{{route('teachers.index')}}">
                teachers
            </a>
        </h1>
        <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Edit</span>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('teachers.update',$teacher)}}" method='post' class="flex flex-col">
        @csrf
        @method('PATCH')
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400">Full Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$teacher->user->name}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Designation</label>
                <select id="" name="designation_id" class="input-indigo p-2">
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}" @if($designation->id==$teacher->designation_id) selected @endif>{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">CNIC</label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="xxxxx-xxxxxxx-x" value="{{$teacher->cnic}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Phone</label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="xxxx-xxxxxxx" value="{{$teacher->phone}}">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk" value="{{$teacher->user->email}}">
            </div>
        </div>

        <button type="submit" class="btn-indigo mt-8">Update</button>
    </form>

</div>

@endsection