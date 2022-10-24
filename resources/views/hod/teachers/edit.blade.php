@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Teachers</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Teachers / edit
    </div>
</div>

<div class="container md:w-3/4 mx-auto px-5">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('teachers.update',$teacher)}}" method='post' class="flex flex-col mt-16">
        @csrf
        @method('PATCH')
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="">Full Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$teacher->user->name}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Designation</label>
                <select id="" name="designation_id" class="input-indigo p-2">
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}" @if($designation->id==$teacher->designation_id) selected @endif>{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC</label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="xxxxx-xxxxxxx-x" value="{{$teacher->cnic}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Phone</label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="xxxx-xxxxxxx" value="{{$teacher->phone}}">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk" value="{{$teacher->user->email}}">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('teachers.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection