@extends('layouts.basic')

@section('body')
<style>
    .hero {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5),
            rgba(0, 0, 50, 0.5)),
        url("{{asset('/images/bg/uo.jpg')}}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-clip: border-box;
        position: relative;
    }
</style>
<div class="hero flex flex-col w-screen h-screen justify-center items-center px-5 bg-gray-600">
    <div class="md:w-1/3 p-8 bg-white relative opacity-80 rounded">
        <div class="text-center">
            <i class="bi-shield-shaded text-6xl text-teal-600"></i>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <form action="{{route('password.update', $user)}}" method="post" class="flex flex-col mt-8" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <label for="" class="mt-3">New Password</label>
            <input type="password" id="new" name="new" class="w-full custom-input" placeholder="Enter your login id" required>
            <label for="" class="mt-3">Confirm Password</label>
            <input type="password" id="confirmpw" class="w-full custom-input" placeholder="Enter your login id" required>
            <label for="" class="mt-3">OTP</label>
            <input type="text" name="code" class="custom-input pl-4" placeholder="- - - -" value="" autocomplete="off">
            <p class="text-xs mt-1">4 digits OTP has been sent to your email account. Please visit your inbox / spam folder. </p>
            <div class="flex space-x-4 mt-6">
                <a href="{{url('/')}}" type="submit" class="w-1/2 btn-orange p-2 text-center rounded">Cancel</a>
                <button type="submit" class="w-1/2 btn-indigo p-2 rounded">Reset Password</button>
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
        if ($('#new').val() != $('#confirmpw').val()) {
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
    }
</script>
@endsection