@extends('layouts.basic')

@section('content')
<div class="flex flex-col items-center justify-center h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="flex flex-col items-center w-full px-5 md:w-1/3">
        <img class="w-full" alt="logo" src="{{asset('/images/logo/logo.png')}}">
        <h1 class="text-lg md:text-4xl font-thin text-indigo-900 mt-4 font-culpa tracking-wider">Exam System</h1>

        <div class="w-full mt-4">

            @if ($errors->any())
            <div class="alert-danger text-sm w-full mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <h3 class="text-xs">Not a user? Please, contact system admin!</h3>
            <form action="{{url('login')}}" method="post" class="w-full mt-1">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="flex items-center w-full relative">
                        <i class="bi bi-envelope-at absolute left-2 text-slate-600"></i>
                        <input type="text" id="email" name="email" class="w-full input-indigo px-8" placeholder="Type your email here">
                    </div>
                    <div class="flex items-center w-full mt-3 relative">
                        <i class="bi bi-key absolute left-2 text-slate-600 -rotate-[45deg]"></i>
                        <input type="password" id="password" name="password" class="w-full input-indigo px-8" placeholder="default password: password">
                        <!-- eye -->
                        <i class="bi bi-eye-slash absolute right-2 eye-slash" onclick="showpw()"></i>
                        <i class="bi bi-eye absolute right-2 eye hidden" onclick="hidepw()"></i>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 absolute right-2 eye" onclick="showpw()">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg> -->
                        <!-- eye slash -->
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 absolute right-2 eye-slash hidden" onclick="hidepw()">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg> -->
                    </div>

                    <button type="submit" class="w-full mt-6 btn-indigo p-2">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function showpw() {
        $('#password').prop({
            type: "text"
        });
        $('.eye-slash').hide()
        $('.eye').show();
    }

    function hidepw() {
        $('#password').prop({
            type: "password"
        });
        $('.eye-slash').show()
        $('.eye').hide();
    }
</script>

@endsection