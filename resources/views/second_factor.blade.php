@extends('layouts.basic')

@section('content')
<section class="text-gray-600 body-font px-2 md:px-24">
    <div class="container mx-auto flex py-24 md:flex-row items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl md:text-4xl mb-4 font-medium text-gray-900">2-Step Verification</h1>
            <p class="mb-8 leading-relaxed">Please enter 2-step verification code, sent on your gmail</p>
            <form action="{{url('verify/step2')}}" method="post">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="w-full">
                        <label for="hero-field" class="leading-7 text-sm text-gray-600">Verification Code</label>
                        <input type="text" id="id" name="two_step_code" class="w-full input-indigo" placeholder="- - - -">
                    </div>
                    <button type='submit' class="w-full md:w-1/4 mt-4 btn-indigo">Verify</button>
                </div>
            </form>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='700'>
        </div>
    </div>
</section>
@endsection