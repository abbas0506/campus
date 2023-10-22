@extends('layouts.internal')
@section('page-content')

<div class="container">
    <h2>Change Password</h2>
    <div class="bread-crumb">
        <a href="{{url('internal')}}">Cancel & Go Back</a>
    </div>

    <div class="mt-8">
        <div class="flex flex-col md:flex-row md:items-center border border-dashed p-4 rounded gap-x-4">
            <i class="bi-info-circle text-2xl text-indigo-600"></i>
            <div class="flex-grow text-left sm:mt-0">
                <ul class="text-sm ml-4">
                    <li>Try to use strong and long password that may consist of capital letters, small letters, digits, underscore and any other special character. However, currently there is no restriction from app</li>
                </ul>
            </div>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <div class="p-8 bg-slate-100 mt-8">


            <form action="{{route('change.pw', Auth::user()->id)}}" method="post" class="flex flex-col md:w-1/2 lg:w-2/5 mx-auto" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')

                <label for="" class="text-xs">Current Password *</label>
                <input type="text" id="current" name="current" class="custom-input py-1" placeholder="Current password" required>
                <label for="" class="mt-3 text-xs">New Password *</label>
                <input type="password" id="new" name="new" class="w-full custom-input py-1" placeholder="New password" required>
                <label for="" class="mt-3 text-xs">Confirm Password *</label>
                <input type="password" id="confirmpw" class="w-full custom-input py-1" placeholder="Confirm password" required>

                <button type="submit" class="mt-6 btn-teal py-1 rounded">Update Now</button>

            </form>
        </div>

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
        // return false;

    }
</script>
@endsection