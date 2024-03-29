@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('programs.index')}}">Programs</a></h1>
<div class="bread-crumb">{{$program->name}} / edit </div>
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

    <form action="{{route('programs.update',$program)}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        @method('PATCH')
        <label for="">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Bachelor of Science in Computer Science" value="{{$program->name}}" required>

        <div class="flex items-center space-x-4 ">
            <div class="flex flex-col grow">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="input-indigo" placeholder="For example: BSCS" value="{{$program->short}}">
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Total Credits</label>
                <input type="number" id='' name='credit_hrs' class="input-indigo" placeholder="Credit hrs" value="{{$program->credit_hrs}}" required>
            </div>
        </div>

        <div class="flex space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Min Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="min_duration" class="input-indigo p-2" required>
                    @foreach($durations as $duration)
                    <option value="{{$duration}}" @if($program->min_duration==$duration) selected @endif>{{$duration}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="max_duration" class="input-indigo p-2" required>
                    @foreach($durations as $duration)
                    <option value="{{$duration}}" @if($program->max_duration==$duration) selected @endif>{{$duration}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Update</button>
        </div>
    </form>

</div>

@endsection