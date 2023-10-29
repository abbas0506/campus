@extends('layouts.basic')

@section('body')


<div class="flex justify-center items-center w-screen h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="p-5"><!-- page message -->

        <h1 class="text-xl">Sign out</h1>
        <p class="text-sm">Do you really want to sign out from exam portal?</p>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <div class="flex flex-wrap items-center gap-x-4 mt-4">
            <a href="{{url(session('role'))}}" class="btn-blue flex-1 text-center">No</a>
            <a href="{{url('signout')}}" class="btn-red flex-1 text-center">Yes</a>

        </div>

    </div>

</div>

@endsection