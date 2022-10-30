@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Sections</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{url('choose-program')}}" class="text-orange-700 mx-1"> Choose semester </a> / {{$semester->title()}} / sections / new
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
    @if(session('error'))
    <div class="flex alert-danger mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('error')}}
    </div>
    @endif
    <form action="{{route('sections.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf

        <input type="text" name="program_id" value="{{$program_id}}" hidden>
        <input type="text" name="shift_id" value="{{$shift_id}}" hidden>

        <label for="" class="mt-3">Section Title</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="A">

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('sections.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection