@extends('layouts.basic')

@section('content')
<x-header></x-header>
<div class="flex flex-col w-screen h-screen justify-center items-center">


    @if ($errors->any())
    <div class="alert-danger text-sm w-2/3 mx-auto mb-3">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('success'))
    <div class="alert-success text-sm w-2/3 mx-auto mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif
    <div class="flex space-x-16 w-3/4">
        <div class="flex justify-center items-center">
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-64 h-64">
        </div>

        <div class="flex flex-col flex-1">

            <form action="{{url('changepw')}}" method="post" class="flex flex-col w-full md:w-3/4 md:mx-auto bg-white p-5" onsubmit="return validate(event)">
                @csrf
                <label for="">Old Password</label>
                <input type="text" id="oldpw" name="oldpw" class="w-full input-indigo" placeholder="Enter your login id" required>
                <label for="" class="mt-3">New Password</label>
                <input type="password" id="newpw" name="newpw" class="w-full input-indigo" placeholder="Enter your login id" required>
                <label for="" class="mt-3">Confirm Password</label>
                <input type="password" id="confirmpw" class="w-full input-indigo" placeholder="Enter your login id" required>

                <div class="flex space-x-4">

                    <a href="{{Str::lower(session('current_role'))}}" class="w-full mt-6 btn-teal p-2 text-center">Go Back</a>
                    <button type="submit" class="w-full mt-6 btn-indigo p-2">Change Password</button>
                </div>
            </form>
        </div>

    </div>
</div>
<script type="module">
    $('#toggle-current-user-dropdown').click(function() {
        $("#current-user-dropdown").toggle();
    });
    $('#menu').click(function() {
        $("#sidebar").toggle();
    });
</script>
@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        if ($('#newpw').val() != $('#confirmpw').val()) {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Confirm password not matched',
                showConfirmButton: false,
                timer: 1500,
            })

        }

        return validated;
        // return false;

    }
</script>
@endsection