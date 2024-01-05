@extends('layouts.basic')

@section('body')


<div class="flex flex-col items-center justify-center h-screen bg-gray-600 px-5">
    <div class="flex flex-col items-center w-full p-8 md:w-1/3 bg-white relative">
        <a href="{{url('signout')}}" class="absolute top-1 right-2"><i class="bi-x text-black"></i></a>
        <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-48 h-48 mt-8">
        <!-- <h1 class="text-2xl md:text-4xl font-thin text-indigo-900 font-culpa tracking-wider">Exam Portal</h1> -->

        <div>
            <h1 class="text-xl mt-8">Please confirm that it is really <a href="{{url('/')}}">you!</a></h1>
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
                        <!-- <label for="" class="">Verification Code</label> -->
                        <input type="text" id="id" name="code" class="w-full custom-input px-4 py-2" placeholder="- - - -">
                    </div>
                    <!-- <div class="flex justify-end w-full mt-1">
                    <a href="{{url('/')}}" class="link text-slate-700 float-right text-xs">Skip</a>
                </div> -->
                    <button type='submit' class="btn-indigo py-2 rounded">Verify</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection