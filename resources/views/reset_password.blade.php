@extends('layouts.basic')

@section('body')
<div class="flex flex-col w-screen h-screen justify-center items-center">

    <div class="flex space-x-16 w-3/4">
        <div class="flex justify-center items-center">
            <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-64 h-64">
        </div>

        <div class="flex flex-col flex-1">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('resetpassword.update', $user)}}" method="post" class="flex flex-col w-full md:w-3/4 md:mx-auto bg-white p-5" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')
                <label for="" class="mt-3">New Password</label>
                <input type="password" id="new" name="new" class="w-full custom-input" placeholder="Enter your login id" required>
                <label for="" class="mt-3">Confirm Password</label>
                <input type="password" id="confirmpw" class="w-full custom-input" placeholder="Enter your login id" required>
                <label for="" class="mt-3">Verification Code</label>
                <input type="text" name="code" class="custom-input pl-4" placeholder="- - - -" value="" autocomplete="off">

                <div class="flex space-x-4">
                    <button type="submit" class="w-full mt-6 btn-indigo p-2">Reset Password</button>
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