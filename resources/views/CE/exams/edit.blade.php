@extends('layouts.controller')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{url('exams')}}">Examinations </a>
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

    <form action="{{route('exams.update', $exam)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')
        <div class="flex flex-col md:flex-row md:items-center w-full">
            <div class="flex flex-col md:grow">
                <label for="">Select Semester Type</label>
                <select name="exam_type_id" id="" class="input-indigo p-2">
                    @foreach($exam_types as $exam_type)
                    <option value="{{$exam_type->id}}" @if($exam_type->id==$exam->exam_type_id) selected @endif>{{$exam_type->name}}</option>
                    @endforeach
                </select>


            </div>
            <div class="flex flex-col mt-3 md:mt-0 md:ml-3">
                <label for="">Status</label>
                <select name="is_active" id="" class="input-indigo p-2">
                    <option value="1" @if($exam->is_active==1) selected @endif>Open</option>
                    <option value="0" @if($exam->is_active==0) selected @endif>Locked</option>
                </select>
            </div>

        </div>
        <label for="" class='mt-3'>Examination Title <span class="text-sm"></span></label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Spring 2022" value="{{$exam->name}}">
        <button type="submit" class="btn-indigo mt-4">Update</button>
    </form>

</div>

@endsection