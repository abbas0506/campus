@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Sections</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Classes / {{$clas->title()}} / new section
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
    <form action="{{route('sections.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        <input type="hidden" name="clas_id" value='{{$clas->id}}' hidden>
        <label for="">Section Title</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="A">

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('classes.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection