@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12"><a href="{{route('departments.index')}}">Deptt & Headship</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Departments / new
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

    <form action="{{route('departments.store')}}" method='post' class="flex flex-col w-full mt-16">
        @csrf
        <label for="">Full Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Department of Analytical Chemistry">

        <label for="" class='mt-3'>Display Name <span class="text-sm text-orange-700">(to be displayed on final degree)</span></label>
        <input type="text" id='' name='title' class="input-indigo" placeholder="Department of Chemistry">

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection