@extends('layouts.hod')
@section('page-content')
<div class="container md:w-3/4 mx-auto px-5 md:px-0">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-10">
            <a href="{{route('sections.index')}}">Sections</a>
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

    <div class="flex text-slate-600 text-sm mb-4">
        {{$clas->title()}}
    </div>
    <form action="{{route('sections.store')}}" method='post' class="flex flex-col w-full">
        @csrf
        <input type="hidden" name="clas_id" value='{{$clas->id}}' hidden>
        <label for="">Section Title</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="A">

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection