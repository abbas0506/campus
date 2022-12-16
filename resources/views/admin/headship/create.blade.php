@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12"><a href="{{route('departments.index')}}">Deptt & Headship</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$selected_department->name}} / assign hod
    </div>
</div>
<div class="container px-8 mt-12">

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4 mx-auto">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif

    <form action="{{route('headship.store')}}" method='post' class="flex flex-col w-full md:w-3/4 mx-auto mt-8">
        @csrf
        <label for="">HOD Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class='mt-3'>Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <label for="" class='mt-3'>CNIC <span class="ml-1 text-gray-500">( 3530112345671 )</span></label>
        <input type="text" id='cnic' name='cnic' class="input-indigo" placeholder="Enter CNIC">

        <input type="text" name="department_id" value="{{$selected_department->id}}" hidden>
        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection