@extends('layouts.admin')
@section('page-content')
<h1 class="mt-5">Users</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('users.index')}}">Users</a> / {{$user->name}} / edit
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

    <form action="{{route('users.update',$user)}}" method='post' class="flex flex-col w-full mt-12">
        @csrf
        @method('PATCH')

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Full Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Dr. Sajjad Ahmad" value="{{$user->name}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Designation</label>
                <select id="" name="designation_id" class="input-indigo p-2">
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}" @if(@$designation->id==$user->teacher->designation_id) selected @endif>{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span class="text-xs">: 3530112345671</span></label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="Without dashes" value="{{$user->teacher->cnic}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="">Phone <span class="text-xs">: 03001234567</span></label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="Without dash" value="{{$user->teacher->phone}}">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk" value="{{$user->email}}">
            </div>
        </div>


        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('users.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Update</button>
        </div>
    </form>

</div>

@endsection