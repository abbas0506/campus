@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Edit Teacher</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('teachers.index')}}">Teachers</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('teachers.update',$teacher)}}" method='post' class="flex flex-col mt-16">
            @csrf
            @method('PATCH')
            <div class="flex flex-col md:flex-row">
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Teacher Name</label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Dr. Sajjad Ahmad" value="{{$teacher->name}}" required>
                </div>
            </div>

            <div class="flex flex-col flex-1 mt-3">
                <label for="">Email</label>
                <input type="text" id='' name='email' class="custom-input" placeholder="abc@uo.edu.pk" value="{{$teacher->email}}" required>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">CNIC <span id="cnic_length" class="text-slate-500 text-xs ml-3">0/13</span></label>
                    <input type="text" id='cnic' name='cnic' class="custom-input" placeholder="Without dashes" value="{{$teacher->cnic}}" required>
                </div>
                <div class="flex flex-col flex-1 mt-3">
                    <label for="">Phone <span id="phone_length" class="text-slate-500 text-xs ml-3">0/11</span></label>
                    <input type="text" id='phone' name='phone' class="custom-input" placeholder="Without dash" value="{{$teacher->phone}}" required>
                </div>
            </div>
            <div class="flex mt-6">
                <button type="submit" class="btn-blue rounded p-2 w-24">Update</button>
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