@extends('layouts.basic')

@section('body')
<style>
    .main {
        position: relative;
        overflow: hidden;
    }

    .main::before {
        background: #edf3fb;
        content: "";
        position: absolute;
        width: 30rem;
        height: 30rem;
        border-radius: 50%;
        align-items: center;
        display: flex;
        justify-content: center;
        transform: scale(120%);
        z-index: -1;
    }
</style>
<div class="main flex flex-col w-screen h-screen justify-center items-center">
    <div class="flex justify-center items-center">
        <img src="{{asset('/images/lock.png')}}" alt="lock" class="w-48 h-48">
    </div>
    <div class="flex flex-col w-full sm:w-4/5 md:w-1/2 lg:w-1/3">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('passwords.change', Auth::user()->id)}}" method="post" class="grid gap-4 mt-4 w-2/3 mx-auto" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')

            <input type="text" id="current" name="current" class="custom-input-borderless py-1" placeholder="Current password" required>
            <input type="password" id="new" name="new" class="custom-input-borderless py-1" placeholder="New password" required>
            <input type="password" id="confirmpw" class="custom-input-borderless py-1" placeholder="Confirm password" required>

            <div class="flex flex-wrap justify-center gap-x-4 mt-4">
                <a href="{{url(session('role'))}}" class="btn-teal text-center rounded-sm py-1">Cancel</a>
                <button type="submit" class="btn-blue rounded-sm py-1">Change Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        if ($('#new').val() != $('#confirmpw').val()) {
            validated = false;
            event.preventDefault();
            Toast.fire({
                icon: 'warning',
                title: 'Confirm password not matched',
            })

        }

        return validated;
    }
</script>
@endsection