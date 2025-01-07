@extends('layouts.basic')

@section('body')
<style>
    .hero {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5),
            rgba(0, 0, 50, 0.5)),
        url("{{asset('/images/bg/uo.jpg')}}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-clip: border-box;
        position: relative;
    }
</style>

<div class="hero flex flex-col items-center justify-center h-screen px-5">
    <div class="flex flex-col justify-between items-center w-full p-5 md:p-8 md:w-1/3 bg-white relative opacity-80 rounded">
        <div>
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-24 mx-auto">
        </div>
        <h2 class="mt-6 text-center">Welcome, {{ Auth::user()->name }}</h2>
        <ol class="flex items-center w-2/3 mt-4">
            <li class="flex w-full items-center text-green-600  after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block">
                <span class="flex items-center justify-center w-10 h-10 bg-teal-200 rounded-full shrink-0">
                    <i class="bi-check-lg"></i>
                </span>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full shrink-0">
                    2
                </span>
            </li>
        </ol>

        <div class="text-center mt-4">
            <h1 class="text-xl">OTP<a href="{{url('/')}}">?</a></h1>
            <p class="text-sm mt-2">Please check your email (inbox or spam folder) and enter 4-digits OTP here without any spaces.</p>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('verify.otp')}}" method="post" class="mt-3 w-full">
                @csrf
                <div class="flex flex-col gap-2">
                    <div class="flex-1">
                        <input type="text" id="id" name="otp" class="w-full custom-input px-4 py-2 text-center" placeholder="- - - -">
                    </div>
                    <button type='submit' class="btn-indigo py-2 rounded">Verify</button>
                </div>
            </form>
        </div>
        <div class="text-center mt-8">
            <a href="{{url('signout')}}" class="text-xs text-slate-600">Cancel / Log Off</a>
        </div>
    </div>
</div>

@endsection