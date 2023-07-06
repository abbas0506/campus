@extends('layouts.admin')
@section('page-content')
<h1><a href="{{route('coursetypes.index')}}">Course Types</a></h1>
<div class="bread-crumb">Course types / new</div>

<div class="flex items-center justify-center w-full h-full">
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('coursetypes.store')}}" method='post' class="flex flex-col w-full md:w-2/3">
        @csrf
        <label for="">Course Type</label>
        <input type="text" id='' name='name' class="input-indigo mt-2" placeholder="Course type name">

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection