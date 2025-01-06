@extends('layouts.basic')

@section('body')
<style>
    .main {
        position: relative;
        overflow: hidden;
    }

    .main::before {
        background: #edf3fb;
        content: "";
        position: absolute;
        width: 30rem;
        height: 30rem;
        border-radius: 50%;
        align-items: center;
        display: flex;
        justify-content: center;
        transform: scale(120%);
        z-index: -1;
    }
</style>

<!-- <div class="main flex justify-center items-center w-screen h-screen bg-gradient-to-b from-blue-100 to-blue-400"> -->
<div class="main flex justify-center items-center w-screen h-screen">
    <div class="p-5 flex flex-col justify-center items-center"><!-- page message -->
        <div><i class="bx bx-log-out-circle text-8xl"></i></div>
        <h1 class="text-4xl">Sign out</h1>
        <p class="mt-4">Do you really want to sign out from exam portal?</p>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <div class="flex flex-wrap items-center gap-x-4 mt-6">
            <a href="{{url(session('role'))}}" class="btn-blue w-24 text-center py-2">No</a>
            <a href="{{url('signout')}}" class="btn-red w-24 text-center py-2">Yes</a>

        </div>

    </div>

</div>

@endsection