@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Change Password</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Change Password</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">
        <div class="flex flex-col md:flex-row md:items-center gap-x-4">
            <i class="bi-info-circle text-2xl text-indigo-600"></i>
            <div class="flex-grow text-left sm:mt-0">
                <h2>Useful Hints</h2>
                <ul class="text-sm">
                    <li>Try to use strong and long password that may consist of capital letters, small letters, digits, underscore and any other special character. However, currently there is no restriction from app</li>
                    <li>Try to keep your password private. Dont disclose it to anyone else.</li>
                </ul>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{url('changepw', Auth::user()->id)}}" method="post" class="flex flex-col mt-8" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <label for="">Current Password</label>
            <input type="text" id="current" name="current" class="w-full custom-input" placeholder="Enter your login id" required>
            <label for="" class="mt-3">New Password</label>
            <input type="password" id="new" name="new" class="w-full custom-input" placeholder="Enter your login id" required>
            <label for="" class="mt-3">Confirm Password</label>
            <input type="password" id="confirmpw" class="w-full custom-input" placeholder="Enter your login id" required>

            <button type="submit" class="mt-6 btn-teal p-2 w-32">Update Now</button>

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