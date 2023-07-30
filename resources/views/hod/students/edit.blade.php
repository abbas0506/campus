@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('clases')}}">Students</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$student->section->title()}} / {{$student->name}} / edit
    </div>
</div>

<div class="container md:w-3/4 mx-auto px-5">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('students.update',$student)}}" method='post' class="flex flex-col w-full">
        @csrf
        @method('PATCH')

        <div class="flex mt-12 space-x-4">
            <div class="flex item-center">
                <input type="radio" name='gender' value="M" @if($student->gender=='M') checked @endif>
                <label for="" class="ml-3">Male</label>
            </div>
            <div class="flex item-center">
                <input type="radio" name='gender' value="F" @if($student->gender=='F') checked @endif>
                <label for="" class="ml-3">Female</label>
            </div>
        </div>
        <label for="" class='mt-8'>Student Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" value="{{$student->name}}" required>
        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="" class=''>Father</label>
                <input type="text" id='' name='father' class="input-indigo" placeholder="father name" value="{{$student->father}}" required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                <input type="text" id='cnic' name='cnic' value="{{$student->cnic}}" class="input-indigo" placeholder="Without dashes">
            </div>

        </div>

        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                <input type="text" id='phone' name='phone' value="{{$student->phone}}" class="input-indigo" placeholder="Without dash">
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='email' name='email' value="{{$student->email}}" class="input-indigo" placeholder="email">
            </div>
        </div>

        <div class="flex flex-col flex-1 mt-3">
            <label for="">Address</label>
            <input type="text" id='address' name='address' value="{{$student->address}}" class="input-indigo" placeholder="address">
        </div>

        <div class="border-b border-dashed border-slate-500 mt-3 h-4"></div>

        <div class="flex md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Roll No</label>
                <input type="text" name="rollno" class="input-indigo" placeholder="Roll No." value="{{$student->rollno}}" required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Reg. No</label>
                <input type="text" name="regno" class="input-indigo" placeholder="Registration No." value="{{$student->regno}}">
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
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