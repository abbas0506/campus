@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Courses</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('courses.index')}}">Courses</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <h1 class="text-red-600">{{$course->name}}</h1>

        <form action="{{route('courses.update',$course)}}" method='post' class="flex flex-col w-full mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <label>Course Type</label>
                <div class="md:col-span-2">
                    <select name="course_type_id" id="" class="custom-input md:w-1/2">
                        @foreach($course_types as $course_type)
                        <option value="{{$course_type->id}}" @if($course->course_type_id==$course_type->id) selected @endif>{{$course_type->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label>Full Name</label>
                    <input type="text" id='full_name' name='name' class="custom-input" placeholder="Software Engineering" value="{{$course->name}}">
                </div>

                <div>
                    <label>Short Name <span class="text-sm">(if any)</span></label>
                    <input type="text" id='short_name' name='short' class="custom-input" placeholder="For example: SE" value="{{$course->short}}">
                </div>

                <div>
                    <label>Course Code</label>
                    <input type="text" id='code' name='code' class="custom-input" placeholder="ZOOL-B-009" value="{{$course->code}}">
                </div>
                <div>
                    <label>Cr Hrs (Theory)</label>
                    <input id="" type='number' name="cr_theory" class="custom-input" placeholder="Crdit Hrs" value="{{$course->cr_theory}}" required>
                </div>
                <div>
                    <label>Cr Hrs (Practical)</label>
                    <input id="" type='number' name="cr_practical" class="custom-input" placeholder="0 if no practical" value="{{$course->cr_practical}}" min=0 required>
                </div>
                <div>
                    <label>Marks (Theory)</label>
                    <input type='number' id="" name="marks_theory" class="custom-input" placeholder="Marks" value="{{$course->marks_theory}}" min=0 required>
                </div>
                <div>
                    <label>Marks (Practical)</label>
                    <input type='number' id="" name="marks_practical" class="custom-input" placeholder="0 if no practical" value="{{$course->marks_practical}}" min=0 required>
                </div>
                <div>

                </div>

            </div>
            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2">Update Now</button>
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