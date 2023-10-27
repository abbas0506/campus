@extends('layouts.coordinator')
@section('page-content')
<div class="container">
    <h2>Freeze</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('coordinator.students.index')}}">Student Profile</a>
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

        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg bg-slate-100">

            <h2>{{ $student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father }}</h2>
            <h3>{{ $student->rollno }}</h3>
            <label>{{$student->address}}</label>
        </div>

        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg mt-2">
            <label for="" class="text-xs">Current Section</label>
            <h2>{{$student->section->title()}}</h2>
            <form action="{{route('coordinator.suspension.update',$student)}}" method='post' class="flex flex-col">
                @csrf
                @method('PATCH')
                <label for="" class="text-xs mt-3">Change Status to</label>
                <select name="status_id" id="" class="custom-input">
                    <option value="">Select a status</option>
                    @foreach($statuses->where('id','>',2) as $status)
                    <option value="{{$status->id}}">{{$status->name}}</option>
                    @endforeach
                </select>
                <label for="" class="text-xs mt-3">Remarks</label>
                <textarea name="remarks" id="" cols="30" rows="2" class="custom-input"></textarea>
                <button type="submit" class="btn-red p-2 rounded mt-4">Update Status</button>
            </form>
        </div>
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