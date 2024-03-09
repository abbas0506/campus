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
    <div class="md:w-1/3 px-8 py-3 bg-white relative opacity-80">
        <div class="flex justify-center items-center">
            <!-- <i class="bi-shield-shaded text-8xl"></i> -->
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-36 h-36">
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('resetpassword.sendcode')}}" method="post" class="flex flex-col mt-8" onsubmit="return validate(event)">
            @csrf
            <label for="" class="mt-3">Your Email</label>
            <input type="text" name="email" class="custom-input" placeholder="Enter your email" required>
            <div class="text-xs mt-1">Secret code will be sent to only registered email account. The code will remain valid for five minutes.</div>
            <div class="flex space-x-4">
                <button type="submit" class="w-full mt-6 btn-indigo p-2">Send Code</button>
            </div>
        </form>

        <div class="mt-8 text-xs text-slate-600 text-center">
            <a href="{{url('/')}}">Not now, do it later</a>
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
        // return false;

    }
</script>
@endsection