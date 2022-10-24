@extends('layouts.hod')
@section('page-content')

<h1 class="mt-5">Programs</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Programs / create
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

    <form action="{{route('programs.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        <label for="">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Bachelor of Science in Computer Science ">

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: BSCS">
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class='mt-3'>Min Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="min_duration" class="input-indigo p-2">
                    @foreach($durations as $duration)
                    <option value="{{$duration}}">{{$duration}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col md:w-48 md:ml-4">
                <label for="" class='mt-3'>Max Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="max_duration" class="input-indigo p-2">
                    @foreach($durations as $duration)
                    <option value="{{$duration}}">{{$duration}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <input type="text" name='department_id' value="{{Auth::user()->teacher->department_id}}" hidden>
        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('programs.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>

    </form>

</div>

@endsection