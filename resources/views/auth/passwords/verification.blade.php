@extends('layouts.basic')

@section('body')


<div class="flex justify-center items-center w-screen h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="md:w-1/3 px-5">
        <h1 class="text-xl">Please confirm that it is really you!</h1>
        <p class="text-sm mt-2">Check your email inbox/spam folder and enter 4-digits code here without any spaces.</p>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('auth.verify')}}" method="post" class="mt-3">
            @csrf
            <div class="flex flex-col w-full items-start">
                <div class="w-full">
                    <!-- <label for="" class="">Verification Code</label> -->
                    <input type="text" id="id" name="code" class="w-full custom-input pl-4" placeholder="- - - -">
                </div>
                <div class="flex justify-end w-full mt-1">
                    <a href="{{url('/')}}" class="link text-slate-700 float-right text-xs">Skip</a>
                </div>
                <button type='submit' class="w-full md:w-1/4 btn-indigo">Verify</button>
            </div>
        </form>
    </div>

</div>

@endsection