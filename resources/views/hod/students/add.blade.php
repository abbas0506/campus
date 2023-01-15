@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('sections.show',$section)}}"> Students</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$section->title()}} / <span class="font-bold pl-1">New student</span>
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
    <form action="{{route('students.store')}}" method='post' class="flex flex-col w-full">
        @csrf
        <input type="text" name="section_id" value="{{$section->id}}" hidden>
        <div class="flex item-cetner mt-12">
            <input type="radio" name='gender' value="M" checked>
            <label for="" class="ml-3">Male</label>
        </div>
        <div class="flex item-cetner mt-3">
            <input type="radio" name='gender' value="F">
            <label for="" class="ml-3">Female</label>
        </div>

        <label for="" class='mt-8'>Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad">

        <label for="" class='mt-3'>Father</label>
        <input type="text" id='' name='father' class="input-indigo" placeholder="father name">
        <div class="flex md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Roll No</label>
                <input type="text" name="rollno" class="input-indigo" placeholder="Roll No.">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Reg. No</label>
                <input type="text" name="regno" class="input-indigo" placeholder="Registration No.">
            </div>
        </div>
        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection