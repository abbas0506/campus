@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Classes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Classes / <a href="{{url('class-options')}}" class="text-orange-700 mx-1"> choose semester </a> / new class
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


    <form action="{{route('classes.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        <!-- <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Shift</h2> -->

        @foreach($shifts as $shift)
        <div class="flex item-cetner mt-3">
            <input type="radio" name='shift_id' value="{{$shift->id}}" @if($shift->id==1) checked @endif>
            <label for="" class="ml-3">{{$shift->name}}</label>
        </div>
        @endforeach

        <label for="" class='mt-8'>Program</label>
        <select id="" name="program_id" class="input-indigo p-2">
            <option value="">Select a program</option>
            @foreach($programs->sortBy('name') as $program)
            <option value="{{$program->id}}">{{$program->name}}</option>
            @endforeach
        </select>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('classes.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection