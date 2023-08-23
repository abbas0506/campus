@extends('layouts.basic')

@section('body')

<div class="flex flex-col-reverse md:flex-row items-center w-screen md:h-screen">
    <div class="flex flex-col md:w-1/2 text-center md:text-left md:pl-36">
        <h1 class="text-2xl md:text-4xl font-medium text-indigo-900 mb-1">2-Step Verification</h1>
        <p class="mb-6 leading-relaxed text-slate-500">Please enter 4-digits code, sent to your gmail</p>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{url('two/fa')}}" method="post">
            @csrf
            <div class="flex flex-col w-full items-start">
                <div class="w-full">
                    <label for="hero-field" class="leading-7 text-sm text-gray-600">Verification Code</label>
                    <input type="text" id="id" name="code" class="w-full custom-input" placeholder="- - - -">
                </div>
                <button type='submit' class="w-full md:w-1/4 mt-4 btn-indigo">Verify</button>
            </div>
        </form>
        <a href="{{url('/')}}">Go to my dashboard anyway</a>
    </div>
    <div class="flex justify-center md:w-1/2">
        <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='700'>
    </div>
</div>
@endsection