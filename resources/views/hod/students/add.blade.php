@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>New Student</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.sections.show',$section)}}">{{$section->title()}}</a>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('hod.students.store')}}" method='post' class="flex flex-col w-full mt-8">
            @csrf
            <input type="text" name="section_id" value="{{$section->id}}" hidden>

            <div class="flex items-center space-x-4">
                <div class="flex item-center">
                    <input type="radio" name='gender' value="M" checked>
                    <label class="ml-3">Male</label>
                </div>
                <div class="flex item-center">
                    <input type="radio" name='gender' value="F">
                    <label class="ml-3">Female</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
                <div>
                    <label>Roll No *</label>
                    <input type="text" name="rollno" class="custom-input" placeholder="Roll No." value="" required>
                </div>
                <div>
                    <label>Reg. No</label>
                    <input type="text" name="regno" class="custom-input" placeholder="Registration No." value="">
                </div>
                <div class="md:col-span-2">
                    <label class='mt-8'>Student Name *</label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Student name" value="" required>
                </div>
                <div>
                    <label class=''>Father</label>
                    <input type="text" id='' name='father' class="custom-input" placeholder="father name" value="">
                </div>
                <div>
                    <label>CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                    <input type="text" id='cnic' name='cnic' value="" class="custom-input" placeholder="Without dashes">
                </div>
                <div>
                    <label>Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                    <input type="text" id='phone' name='phone' value="" class="custom-input" placeholder="Without dash">
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" id='email' name='email' value="" class="custom-input" placeholder="email">
                </div>
                <div class="md:col-span-2">
                    <label>Address</label>
                    <input type="text" id='address' name='address' value="" class="custom-input" placeholder="address">
                </div>

            </div>

            <div class="flex">
                <button type="submit" class="btn-teal rounded py-2 mt-4">Create Now</button>
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
    });

    $('#phone').on('input', function() {
        var phone = $('#phone').val()
        $('#phone_length').html(phone.length + "/11");
    });
</script>
@endsection