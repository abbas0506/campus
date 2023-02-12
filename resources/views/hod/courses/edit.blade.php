@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('courses.index')}}">Courses</a></h1>
<div class="bread-crumb">{{$course->name}} / edit</div>
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

    <form action="{{route('courses.update',$course)}}" method='post' class="flex flex-col w-full mt-12" onsubmit="return validate(event)">
        @csrf
        @method('PATCH')
        <div class="flex flex-row items-center">
            <label for="" class='mr-4 text-orange-600'>Course Type:</label>
            {{$course->course_type->name}}
        </div>

        <label for="" class="mt-3">Full Name</label>
        <input type="text" id='full_name' name='name' class="input-indigo" placeholder="Software Engineering" value="{{$course->name}}">

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='short_name' name='short' class="input-indigo" placeholder="For example: SE" value="{{$course->short}}">
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Course Code</label>
                <input type="text" id='code' name='code' class="input-indigo" placeholder="ZOOL-B-009" value="{{$course->code}}">
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Theory)</label>
                <input id="" type='number' name="credit_hrs_theory" class="input-indigo p-1 pl-2" placeholder="Crdit Hrs" value="{{$course->credit_hrs_theory}}" required>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Theory)</label>
                <input type='number' id="" name="max_marks_theory" class="input-indigo p-1 pl-2" placeholder="Marks" value="{{$course->max_marks_theory}}" min=0 required>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Credit Hrs (Practical)</label>
                <input id="" type='number' name="credit_hrs_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->credit_hrs_practical}}" min=0 required>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Marks (Practical)</label>
                <input type='number' id="" name="max_marks_practical" class="input-indigo p-1 pl-2" placeholder="0 if no practical" value="{{$course->max_marks_practical}}" min=0 required>
            </div>

        </div>

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Update</button>
        </div>
    </form>

</div>

@endsection

@section('script')
<script>
    function validate(event) {
        var validated = true;

        if ($('#course_type').val() == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Please select a course type',
                showConfirmButton: false,
                timer: 1500,
            })

        } else if ($('#full_name').val() == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Full name missing',
                showConfirmButton: false,
                timer: 1500,
            })

        } else if ($('#short_name').val() == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Short name missing',
                showConfirmButton: false,
                timer: 1500,
            })

        } else if ($('#course_type').val() == 1 && $('#code').val() == '') {
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