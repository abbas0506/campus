@extends('layouts.basic')

@section('content')
<section class="w-screen text-gray-600 body-font px-2 md:px-24">
    <div class="container mx-auto flex py-24 md:flex-row flex-col-reverse items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl md:text-4xl mb-4 font-medium text-gray-900">EXAMINATION SYSTEM</h1>
            <p class="mb-8 leading-relaxed">University of Okara, Pakistan</p>

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
                    <button type="submit" class="w-full md:w-1/4 mt-4 btn-indigo">Login</button>
                </div>
                @error('auth')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3" role="alert" id='close_alert'>
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">User not found</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="hideme()">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                @enderror
            </form>


        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='700'>
        </div>
    </div>
</section>
<script>
    function hideme() {
        document.getElementById('close_alert').hidden = true
    }
</script>
@endsection