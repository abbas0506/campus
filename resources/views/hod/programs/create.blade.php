@extends('layouts.hod')
@section('page-content')
<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('programs.index')}}">Programs</a>
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

    <form action="{{route('programs.store')}}" method='post' class="flex flex-col w-full">
        @csrf
        <label for="" class="text-sm text-gray-400">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Bachelor of Science in Computer Science ">

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class="text-sm text-gray-400 mt-3">Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: BSCS">
            </div>
            <!-- <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Program Code</label>
                <input type="text" id='' name='code' class="input-indigo" placeholder="Enter program code">
            </div> -->
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class="text-sm text-gray-400 mt-3">Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="duration" class="input-indigo p-2">
                    <option value="2">2</option>
                    <option value="4" selected>4</option>
                </select>
            </div>
        </div>
        <!-- <label for="" class="text-sm text-gray-400 mt-3">Department</label> -->
        <select id="" name="department_id" class="input-indigo p-2" hidden>
            <option value="">Select a department</option>
            @foreach($departments->sortBy('name') as $department)
            <option value="{{$department->id}}" @if($department->id==Auth::user()->employee->department_id) selected @endif>{{$department->name}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection