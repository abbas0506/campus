@extends('layouts.basic')

@section('content')
<div class="flex flex-col-reverse md:flex-row items-center w-screen md:h-screen bg-teal-800">
    <div class="flex flex-col md:w-1/2 text-center md:text-left md:pl-36">
        <h1 class="text-2xl md:text-4xl font-medium text-slate-50 mb-1">EXAMINATION SYSTEM</h1>
        <p class="mb-6 leading-relaxed text-slate-300">University of Okara, Pakistan</p>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{url('login')}}" method="post" class="w-full">
            @csrf
            <div class="flex flex-col w-full items-start">
                <div class="w-full">
                    <label for="hero-field" class="leading-7 text-sm text-gray-600">User ID</label>
                    <input type="text" id="email" name="email" class="w-full input-indigo" placeholder="Enter your login id">
                </div>
                <div class="w-full mt-3">
                    <label for="hero-field" class="leading-7 text-sm text-gray-600">Password</label>
                    <input type="password" id="password" name="password" class="w-full input-indigo" placeholder="Enter your login id">
                </div>
                <button type="submit" class="w-full md:w-1/4 mt-4 btn-indigo p-2">Login</button>
            </div>
        </form>
    </div>
    <div class="flex justify-center md:w-1/2">
        <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo.png')}}" width='700'>
    </div>
</div>
@endsection