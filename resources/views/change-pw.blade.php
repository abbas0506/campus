@extends('layouts.basic')

@section('body')

<div class="flex flex-col w-screen h-screen justify-center items-center">
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

        <form action="{{route('change.pw', Auth::user()->id)}}" method="post" class="flex flex-col mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')

            <input type="text" id="current" name="current" class="custom-input py-1" placeholder="Current password" required>
            <input type="password" id="new" name="new" class="custom-input py-1" placeholder="New password" required>
            <input type="password" id="confirmpw" class="custom-input py-1" placeholder="Confirm password" required>

            <div class="flex flex-wrap space-x-4 mt-4">
                <a href="{{url(session('current_role'))}}" class="flex-1 btn-teal text-center rounded-sm py-1">Not Now</a>
                <button type="submit" class="flex-1 btn-indigo rounded-sm py-1">Change Password</button>
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