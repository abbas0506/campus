@extends('layouts.hod')
@section('page-content')
<h1><a href="{{route('teachers.index')}}">Teachers</a></h1>
<div class="bread-crumb">New teacher</div>

<div class="container md:w-3/4 mx-auto px-5">
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form action="{{route('teachers.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf

        <div class="flex flex-col md:flex-row">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Teacher Name</label>
                <input type="text" id='' name='name' class="custom-input" placeholder="Dr. Sajjad Ahmad" required>
            </div>
        </div>

        <div class="flex flex-col flex-1 mt-3">
            <label for="">Email</label>
            <input type="text" id='' name='email' class="custom-input" placeholder="abc@uo.edu.pk" required>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                <input type="text" id='cnic' name='cnic' class="custom-input" placeholder="Without dashes" required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                <input type="text" id='phone' name='phone' class="custom-input" placeholder="Without dash" required>
            </div>
        </div>
        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>


    </form>
</div>
@endsection

@section('script')
<script type="module">
    $('#cnic').on('input', function() {
        var cnic = $('#cnic').val()
        $('#cnic_length').html(cnic.length + "/13");
    });

    $('#phone').on('input', function() {
        var phone = $('#phone').val()
        $('#phone_length').html(phone.length + "/11");
    });
</script>
@endsection