@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12"><a href="{{route('coursetypes.index')}}">Course Types</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Course types / new
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

    <form action="{{route('coursetypes.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        <label for="">Course Types</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Course type name">

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection