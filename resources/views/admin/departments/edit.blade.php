@extends('layouts.admin')
@section('page-content')
<h1><a href="{{route('departments.index')}}">Departments</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$department->name}} / edit
    </div>
</div>

<div class="flex justify-center items-center w-full h-full">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('departments.update',$department)}}" method='post' class="flex flex-col w-full md:w-2/3">
        @csrf
        @method('PATCH')
        <label for="">Full Name</label>
        <input type="text" id='' name='name' class="custom-input mt-2" placeholder="Enter department name" value="{{$department->name}}">

        <label for="" class='mt-4'>Display Name <span class="text-sm text-orange-700">(to be displayed on final degree)</span></label>
        <input type="text" id='' name='title' class="custom-input mt-2" placeholder="Department of Chemistry" value="{{$department->title}}">

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Update</button>
        </div>
    </form>

</div>

@endsection