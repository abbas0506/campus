@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('employees.index')}}">Employees</a>
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

    <form action="{{route('employees.update',$employee)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Prefix</label>
                <select id="" name="prefix_id" class="input-indigo p-2">
                    @foreach($prefixes as $prefix)
                    <option value="{{$prefix->id}}" @if($prefix->id==$employee->prefix_id) selected @endif>{{$prefix->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Full Name</label>
                <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$employee->user->name}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Designation</label>
                <select id="" name="designation_id" class="input-indigo p-2">
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}" @if($designation->id==$employee->designation_id) selected @endif>{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Job Type</label>
                <select id="" name="jobtype_id" class="input-indigo p-2">
                    @foreach($jobtypes as $jobtype)
                    <option value="{{$jobtype->id}}" @if($jobtype->id==$employee->jobtype_id) selected @endif>{{$jobtype->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Nationality</label>
                <select id="" name="nationality_id" class="input-indigo p-2">
                    @foreach($nationalities as $nationality)
                    <option value="{{$nationality->id}}" @if($nationality->id==$employee->nationality_id) selected @endif>{{$nationality->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">CNIC</label>
                <input type="text" id='' name='cnic' class="input-indigo" placeholder="xxxxx-xxxxxxx-x" value="{{$employee->cnic}}">
            </div>
        </div>
        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                <label for="" class="text-sm text-gray-400">Phone</label>
                <input type="text" id='' name='phone' class="input-indigo" placeholder="xxxx-xxxxxxx" value="{{$employee->phone}}">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class="text-sm text-gray-400">Email</label>
                <input type="text" id='' name='email' class="input-indigo" placeholder="abc@uo.edu.pk" value="{{$employee->user->email}}">
            </div>
        </div>

        <label for="" class="text-sm text-gray-400 mt-3">Address <span class="text-sm">(optional)</span></label>
        <input type="text" id='' name='address' class="input-indigo" placeholder="University of Okara" value="University of Okara" value="{{$employee->address}}">

        <button type="submit" class="btn-indigo mt-4">Update</button>
    </form>

</div>

@endsection