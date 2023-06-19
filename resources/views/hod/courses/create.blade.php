@extends('layouts.hod')
@section('page-content')
<h1><a href="{{route('courses.index')}}">Courses</a></h1>

<div class="bread-crumb">New course</div>

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

    <div class="flex items-center space-x-2 mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
        </svg>
        <ul class="text-xs">
            <li>Be careful while selecting course type. Course type once selected, can't be modified</li>
            <li>Course code is compulsory only for compulsory courses, others as per rule</li>
        </ul>
    </div>

    <form action="{{route('courses.store')}}" method='post' class="flex flex-col w-full mt-4" onsubmit="return validate(event)">
        @csrf

        <div class="flex flex-row items-center">
            <label for="" class='mr-4 text-sm text-orange-600'>Course Type:</label>
            <select id="course_type" name="course_type_id" class="py-1 outline-none" required>
                <option value="">Select a type</option>
                @foreach($course_types as $course_type)
                <option value="{{$course_type->id}}" class="text-gray-800 ">{{$course_type->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="" class="mt-4">Full Name</label>
        <input type="text" id='full_name' name='name' class="input-indigo" placeholder="Object Oriented Programming" required>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any, otherwise same as full name)</span></label>
                <input type="text" id='short_name' name='short' class="input-indigo" placeholder="OOP" required>
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Course Code</label>
                <input type="text" id='code' name='code' class="input-indigo" placeholder="ZOOL-B-009">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value='4' required>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value='100' required>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0 required>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value='0' min=0 required>
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
    function validate(event) {
        var validated = true;

        if ($('#course_type').val() == 1 && $('#code').val() == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Code missing',
                showConfirmButton: false,
                timer: 1500,
            })

        }
        return validated;
        // return false;

    }
</script>
@endsection