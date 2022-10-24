@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Schemes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Schemes / edit
    </div>
</div>

<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('programs.index')}}">Programs</a>
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

    <form action="{{route('programs.update',$program)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <label for="">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Bachelor of Science in Computer Science" value="{{$program->name}}">

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: BSCS" value="{{$program->short}}">
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class='mt-3'>Program Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="Enter program code" value="{{$program->code}}">
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class='mt-3'>Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="duration" class="input-indigo p-2">
                    <option value="2" @if($program->duration==2) selected @endif>2</option>
                    <option value="4" @if($program->duration==4) selected @endif>4</option>
                </select>
            </div>
        </div>
        <label for="" class='mt-3'>Department</label>
        <select id="" name="department_id" class="input-indigo p-2">
            <option value="">Select a department</option>
            @foreach($departments->sortBy('name') as $department)
            <option value="{{$department->id}}" @if($department->id==$program->department_id) selected @endif>{{$department->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-indigo mt-3">Update</button>
    </form>

</div>

@endsection