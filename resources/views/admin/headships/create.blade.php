@extends('layouts.admin')
@section('page-content')
<h1><a href="{{route('departments.index')}}">Create New HoD</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$selected_department->name}} / Assign HoD
    </div>
</div>
<div class="container px-8 mt-12">

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4 mx-auto">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif

    <form action="{{route('headships.store')}}" method='post' class="flex flex-col w-full md:w-3/4 mx-auto mt-4">
        @csrf
        <label for="">HoD Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class='mt-3'>Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <label for="" class='mt-3'>Phone</label>
        <input type="text" id='phone' name='phone' class="input-indigo" placeholder="Enter phone">

        <label for="" class='mt-3'>CNIC <span id="cnic_length" class="text-slate-500 text-sm ml-3">0/13</span></label>
        <input type="text" id='cnic' name='cnic' class="input-indigo" placeholder="Without dashes">

        <input type="text" name="department_id" value="{{$selected_department->id}}" hidden>
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
</script>
@endsection