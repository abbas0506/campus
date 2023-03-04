@extends('layouts.basic')

@section('content')
<div class="flex flex-col md:flex-row md:items-center w-screen min-h-screen">
    <div class="flex flex-col items-center justify-center flex-1 md:h-screen bg-gradient-to-b from-blue-100 to-blue-50">
        <img class="w-2/3" alt="logo" src="{{asset('/images/logo/logo.png')}}">
        <h1 class="text-lg md:text-3xl font-thin text-indigo-900 my-8">EXAMINATION SYSTEM</h1>

    </div>
    <div class="flex flex-1 justify-center items-center">
        <div class="w-full md:w-2/3 justify-center items-center p-8">
            <div class="flex items-center space-x-2 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
                <ul class="text-xs">
                    <li>Only authorized users can login. If you have no user account, contact system admin or your HoD, plz.</li>
                </ul>
            </div>

            @if ($errors->any())
            <div class="alert-danger text-sm w-full mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{url('login')}}" method="post" class="w-full">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="flex items-center w-full relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 absolute left-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <input type="text" id="email" name="email" class="w-full input-indigo pl-8" placeholder="Enter your login id">
                    </div>
                    <div class="flex items-center w-full mt-3 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 absolute left-2 -rotate-90">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                        </svg>
                        <input type="password" id="password" name="password" class="w-full input-indigo pl-8" placeholder="Enter your login id">
                    </div>
                    <button type="submit" class="w-full mt-6 btn-indigo p-2">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection