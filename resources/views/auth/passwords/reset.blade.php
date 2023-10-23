@extends('layouts.basic')

@section('body')
<div class="flex flex-col w-screen h-screen justify-center items-center bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="flex flex-col w-full md:w-2/3 lg:w-1/3 p-4">
        <h1 class="text-2xl">Reset Password</h1>
        <div class="flex flex-col mt-4">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('resetpassword.update', $user)}}" method="post" class="flex flex-col" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')
                <label for="" class="mt-3">New Password</label>
                <input type="password" id="new" name="new" class="w-full custom-input" placeholder="Enter your login id" required>
                <label for="" class="mt-3">Confirm Password</label>
                <input type="password" id="confirmpw" class="w-full custom-input" placeholder="Enter your login id" required>
                <label for="" class="mt-3">Verification Code</label>
                <input type="text" name="code" class="custom-input pl-4" placeholder="- - - -" value="" autocomplete="off">
                <p class="text-xs mt-1">4 digits verification code has been sent to your email account. Please visit your inbox / spam folder. </p>
                <div class="flex space-x-4 mt-6">
                    <a href="{{url('/')}}" type="submit" class="w-1/2 btn-orange p-2 text-center">Go Back</a>
                    <button type="submit" class="w-1/2 btn-indigo p-2">Reset Password</button>
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
        // return false;

    }
</script>
@endsection