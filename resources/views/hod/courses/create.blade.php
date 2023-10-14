@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>New Course</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.courses.index')}}">Courses</a>
        <div>/</div>
        <div>New</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">

        <form action="{{route('hod.courses.store')}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label>Course Type*</label>
                    <div class="">
                        <select name="course_type_id" id="" class="custom-input">
                            @foreach($course_types as $course_type)
                            <option value="{{$course_type->id}}">{{$course_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label>Course Code* (for compulsory only)</label>
                    <input type="text" id='code' name='code' class="custom-input" placeholder="SE-009" value="">
                </div>
                <div class="md:col-span-2">
                    <label>Full Name*</label>
                    <input type="text" id='full_name' name='name' class="custom-input" placeholder="Software Engineering" value="">
                </div>
                <div>
                    <label>Short Name *</label>
                    <input type="text" id='short_name' name='short' class="custom-input" placeholder="For example: SE" value="">
                </div>
                <div>
                    <label>Pre-requisite Course</label>
                    <div class="">
                        <select name="prerequisite_course_id" id="" class="custom-input text-sm">
                            <option value="">None</option>
                            @foreach($courses->sortBy('name') as $course)
                            <option value="{{$course->id}}">{{$course->code}} &nbsp {{$course->name}} &nbsp {{$course->lblCr()}}</span></option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label>Cr Hrs (Theory)*</label>
                    <input id="" type='number' name="cr_theory" class="custom-input" placeholder="Crdit Hrs" value="" required>
                </div>
                <div>
                    <label>Cr Hrs (Practical)*</label>
                    <input id="" type='number' name="cr_practical" class="custom-input" placeholder="0 if no practical" value="" min=0 required>
                </div>
                <div>
                    <label>Marks (Theory)*</label>
                    <input type='number' id="" name="marks_theory" class="custom-input" placeholder="Marks" value="" min=0 required>
                </div>
                <div>
                    <label>Marks (Practical)*</label>
                    <input type='number' id="" name="marks_practical" class="custom-input" placeholder="0 if no practical" value="" min=0 required>
                </div>
                <div>

                </div>

            </div>
            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2">Create Now</button>
            </div>
        </form>

    </div>
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