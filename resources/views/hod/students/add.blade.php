@extends('layouts.hod')
@section('page-content')
<h1><a href="{{route('sections.show',$section)}}"> Students</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$section->title()}} / <span class="font-bold pl-1">New student</span>
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
    <form action="{{route('students.store')}}" method='post' class="flex flex-col w-full">
        @csrf
        <input type="text" name="section_id" value="{{$section->id}}" hidden>
        <div class="flex space-x-4 mt-12">
            <div class="flex item-center">
                <input type="radio" name='gender' value="M" checked>
                <label for="" class="ml-3">Male</label>
            </div>
            <div class="flex item-center">
                <input type="radio" name='gender' value="F">
                <label for="" class="ml-3">Female</label>
            </div>
        </div>

        <label for="" class='mt-8'>Student Name</label>
        <input type="text" id='' name='name' class="input-indigo" placeholder="Sajjad Ahmad" required>

        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Father</label>
                <input type="text" id='' name='father' class="input-indigo" placeholder="father name" required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                <input type="text" id='cnic' name='cnic' class="input-indigo" placeholder="Without dashes" required>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                <input type="text" id='phone' name='phone' class="input-indigo" placeholder="Without dash" required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='email' name='email' class="input-indigo" placeholder="email" required>
            </div>
        </div>

        <label for="" class="mt-3">Address</label>
        <input type="text" id='address' name='address' class="input-indigo" placeholder="address" required>

        <div class="border-b border-dashed border-slate-500 mt-3 h-4"></div>

        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Roll No</label>
                <input type="text" name="rollno" class="input-indigo" placeholder="Roll No." required>
            </div>
            <div class="flex flex-col flex-1 mt-3">
                <label for="">Reg. No</label>
                <input type="text" name="regno" class="input-indigo" placeholder="Registration No.">
            </div>
        </div>
        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection
@section('script')
<script>
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