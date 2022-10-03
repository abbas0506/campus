@extends('layouts.basic')

@section('content')

<div class="flex flex-col-reverse md:flex-row items-center w-screen md:h-screen">
    <div class="flex flex-col md:w-1/2 m-auto text-center">
        <h1 class="text-2xl md:text-4xl font-medium text-indigo-900 mb-1">Login As</h1>
        <p class="mb-6 leading-relaxed text-slate-500">Please select one of the following options</p>

        <div class="flex flex-wrap">
            @foreach(Auth::user()->roles as $role)
            <a href='{{$role->name}}' class="flex-1 text-center bg-indigo-100 text-indigo-900 rounded text-3xl px-4 py-3 mr-4">{{$role->name}}</a>
            @endforeach
        </div>
    </div>
    <!-- <div class="flex justify-center md:w-1/2">
        <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='700'>
    </div> -->
</div>
@endsection