@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>New Teacher</h2>
    <div class="bread-crumb">
        <a href="{{url('coordinator')}}">Home</a>
        <div>/</div>
        <a href="{{route('coordinator.teachers.index')}}">Teachers</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('coordinator.teachers.store')}}" method='post' class="flex flex-col w-full mt-12">
            @csrf

            <div class="flex flex-col md:flex-row">
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Teacher Name *</label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Dr. Sajjad Ahmad" required>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Job Type *</label>
                    <select name="is_regular" id="" class="custom-input">
                        <option value="1">Regular</option>
                        <option value="0">Visiting</option>
                    </select>
                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Email *</label>
                    <input type="text" id='' name='email' class="custom-input" placeholder="abc@uo.edu.pk" required>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">CNIC <span id="cnic_length" class="text-xs ml-3">0/13</span></label>
                    <input type="text" id='cnic' name='cnic' class="custom-input" placeholder="Without dashes">
                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Phone * <span id="phone_length" class="text-xs ml-3">0/11</span></label>
                    <input type="text" id='phone' name='phone' class="custom-input" placeholder="Without dash, first digit 0" required>
                </div>
            </div>
            <div class="flex mt-4 ">
                <button type="submit" class="btn-blue rounded p-2 w-32">Create Now</button>
            </div>
        </form>
    </div>
    @endsection

    @section('script')
    <script type="module">
        $('#cnic').on('input', function() {
            var cnic = $('#cnic').val()
            $('#cnic_length').html(cnic.length + "/13");
            // cnic patten
            var regex = /^[1-9]\d{0,12}$/;
            if (!regex.test(cnic)) {
                if (!$('#cnic_length').hasClass('flash-warning'))
                    $('#cnic_length').addClass('flash-warning');
            } else {
                if ($('#cnic_length').hasClass('flash-warning'))
                    $('#cnic_length').removeClass('flash-warning');
            }
        });

        $('#phone').on('input', function() {
            var phone = $('#phone').val()
            $('#phone_length').html(phone.length + "/11");
            // phone patten
            var regex = /^[0]\d{0,10}$/;
            if (!regex.test(phone)) {
                if (!$('#phone_length').hasClass('flash-warning'))
                    $('#phone_length').addClass('flash-warning');
            } else if ($('#phone_length').hasClass('flash-warning'))
                $('#phone_length').removeClass('flash-warning');

        });
    </script>
    @endsection