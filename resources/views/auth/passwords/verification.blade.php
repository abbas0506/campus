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
    <div class="flex flex-col justify-between items-center w-full h-4/5 py-4 px-8 md:w-1/3 bg-white relative">
        <div>
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-36 h-36 mx-auto">
        </div>
        <div>
            <h1 class="text-xl">Please confirm that it is really <a href="{{url('/')}}">you!</a></h1>
            <p class="text-sm mt-2">Check your email inbox/spam folder and enter 4-digits code here without any spaces.</p>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('auth.verify')}}" method="post" class="mt-3 w-full">
                @csrf
                <div class="flex flex-col gap-2">
                    <div class="flex-1">
                        <input type="text" id="id" name="code" class="w-full custom-input px-4 py-2" placeholder="- - - -">
                    </div>
                    <button type='submit' class="btn-indigo py-2 rounded">Verify</button>
                </div>
            </form>
        </div>
        <div class="text-center">
            <a href="{{url('signout')}}" class="text-xs text-slate-600">Cancel & Go back</a>
        </div>
    </div>
</div>

@endsection