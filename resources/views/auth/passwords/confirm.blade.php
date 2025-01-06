@extends('layouts.basic')

@section('body')

<div class="flex flex-col w-screen h-screen justify-center items-center">
    <div class="flex justify-center items-center">
        <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-48 h-48">
    </div>
    <div class="flex flex-col w-full sm:w-4/5 md:w-1/2 lg:w-1/3">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <a href="{{url(session('role'))}}" class="btn-blue w-full text-center mt-8">Go Next</a>

    </div>
</div>
@endsection