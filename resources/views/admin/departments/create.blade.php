@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('departments.index')}}">Departments</a>
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

    <form action="{{route('departments.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <label for="">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Department of Analytical Chemistry">

        <label for="" class='mt-3'>Display Name <span class="text-sm">(to be displayed on final degree)</span></label>
        <input type="text" id='' name='title' class="input-indigo" placeholder="Department of Chemistry">

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection