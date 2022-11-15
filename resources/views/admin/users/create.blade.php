@extends('layouts.admin')
@section('page-content')
<h1 class="mt-5">Users</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('users.index')}}">Users</a> / create
    </div>
</div>

<div class="md:w-3/4 mx-auto px-5">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('users.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf
        <div class="flex flex-col md:flex-row">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Teacher Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Dr. Sajjad Ahmad">
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Department</label>
                <select name="department_id" id='' class="input-indigo p-2">
                    <option value="">Click here</option>
                    @foreach($departments as $department)
                    <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span class="text-xs">: 3530112345671</span></label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="Without dashes">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Phone <span class="text-xs">: 03001234567</span></label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="Without dash">
            </div>
        </div>
        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('users.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>

    </form>

</div>

@endsection