@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Struck Off</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.students.index')}}">Student Profile</a>
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
        </div>
        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg mt-2">
            <label for="" class="text-xs">Remarks (optional)</label>
            <form action="{{route('hod.students.deactivate')}}" method='post' class="">
                @csrf
                <input type="hidden" name='student_id' value="{{$student->id}}">
                <input type="hidden" name='status_id' value="3">
                <textarea type="" name="remarks" value="" class="custom-input w-full"></textarea>
                <button type="submit" class="btn-red p-2 w-24 rounded mt-4">Struck Off</button>
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