@extends('layouts.basic')

@section('body')
<div class="flex flex-col w-screen h-screen justify-center items-center ">
    <div class="md:w-1/3">
        <div class="flex justify-center items-center">
            <!-- <i class="bi-shield-shaded text-8xl"></i> -->
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-64 h-64">
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('resetpassword.sendcode')}}" method="post" class="flex flex-col" onsubmit="return validate(event)">
            @csrf
            <label for="" class="mt-3">Your Email</label>
            <input type="text" name="email" class="custom-input" placeholder="Enter your email" required>
            <div class="text-xs mt-1">Secret code will be sent to only registered email account. The code will remain valid for five minutes.</div>
            <div class="flex space-x-4">
                <button type="submit" class="w-full mt-6 btn-indigo p-2">Send Code</button>
            </div>
        </form>

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