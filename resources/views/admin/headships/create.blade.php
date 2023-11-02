@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>New HoD</h2>
    <p>{{$department->name}}</p>
    <div class="bread-crumb">
        <a href="{{route('admin.departments.show',$department)}}">Cancel & Go back</a>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <form action="{{route('admin.headships.store')}}" method='post' class="flex flex-col w-full mt-4">
            @csrf
            <input type="text" name="department_id" value="{{$department->id}}" hidden>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>HoD Name *</label>
                    <input type="text" id='name' name='name' class="custom-input" placeholder="Enter name">
                </div>

                <div>
                    <label for="">Email *</label>
                    <input type="text" id='email' name='email' class="custom-input" placeholder="Enter email address">
                </div>

                <div>
                    <label for="">Phone * <span id="phone_length" class="text-xs ml-3">0/11</span></label>
                    <input type="text" id='phone' name='phone' class="custom-input" placeholder="Enter phone">
                </div>

                <div>
                    <label for="">CNIC <span id="cnic_length" class="text-sm ml-3">0/13</span></label>
                    <input type="text" id='cnic' name='cnic' class="custom-input" placeholder="Without dashes">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-indigo-rounded w-24">Save</button>
                </div>
            </div>
        </form>
    </div>

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