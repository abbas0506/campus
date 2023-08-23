@extends('layouts.basic')

@section('body')


<div class="flex justify-center items-center w-screen h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="w-1/2">
        <h1 class="text-2xl md:text-4xl font-medium text-indigo-900 mb-1">2-Step Verification</h1>
        <p class="mb-6 leading-relaxed text-slate-500">Please enter 4-digits code, sent to your email account</p>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{url('two/fa')}}" method="post" class="mt-4">
            @csrf
            <div class="flex flex-col w-full items-start">
                <div class="w-full">
                    <label for="" class="">Verification Code</label>
                    <input type="text" id="id" name="code" class="w-full custom-input pl-4" placeholder="- - - -">
                </div>
                <button type='submit' class="w-full md:w-1/4 mt-4 btn-indigo">Verify</button>
            </div>
        </form>
        <div class="mt-8 border border-dashed border-sky-200 p-4">
            <div class="mb-2">Respected user, you are seeing this screen because of enhanced security measures. Please look into your inbox / spam folder for code </div>
            <a href="{{url('/')}}" class="link">Go to my dashboard anyway</a>
        </div>

    </div>

</div>

@endsection