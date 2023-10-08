@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Edit Student</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.students.index')}}">Students</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <form action="{{route('hod.students.update',$student)}}" method='post' class="mt-8">
            @csrf
            @method('PATCH')

            <div class="flex items-center space-x-4">
                <div class="flex item-center">
                    <input type="radio" name='gender' value="M" @if($student->gender=='M') checked @endif>
                    <label for="" class="ml-3">Male</label>
                </div>
                <div class="flex item-center">
                    <input type="radio" name='gender' value="F" @if($student->gender=='F') checked @endif>
                    <label for="" class="ml-3">Female</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
                <div class="md:col-span-2">
                    <label for="" class='mt-8'>Student Name</label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Sajjad Ahmad" value="{{$student->name}}" required>
                </div>
                <div>
                    <label for="" class=''>Father</label>
                    <input type="text" id='' name='father' class="custom-input" placeholder="father name" value="{{$student->father}}" required>
                </div>
                <div>
                    <label for="">CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                    <input type="text" id='cnic' name='cnic' value="{{$student->cnic}}" class="custom-input" placeholder="Without dashes">
                </div>
                <div>
                    <label for="">Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                    <input type="text" id='phone' name='phone' value="{{$student->phone}}" class="custom-input" placeholder="Without dash">
                </div>
                <div>
                    <label for="">Email</label>
                    <input type="text" id='email' name='email' value="{{$student->email}}" class="custom-input" placeholder="email">
                </div>
                <div class="md:col-span-2">
                    <label for="">Address</label>
                    <input type="text" id='address' name='address' value="{{$student->address}}" class="custom-input" placeholder="address">
                </div>
                <div class="md:col-span-2 border-b border-dashed border-slate-200 mt-3 h-4">
                    <!-- divider -->
                </div>
                <div>
                    <label for="">Roll No</label>
                    <input type="text" name="rollno" class="custom-input" placeholder="Roll No." value="{{$student->rollno}}" required>
                </div>
                <div>
                    <label for="">Reg. No</label>
                    <input type="text" name="regno" class="custom-input" placeholder="Registration No." value="{{$student->regno}}">
                </div>

            </div>
            <div class="flex">
                <button type="submit" class="btn-teal rounded p-2 mt-4">Update Now</button>
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