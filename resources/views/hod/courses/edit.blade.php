@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Edit Course</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.courses.index')}}">Courses</a>
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
        <form action="{{route('hod.courses.update',$course)}}" method='post' class="flex flex-col w-full mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label>Course Type*</label>
                    <div class="">
                        <select name="course_type_id" id="" class="custom-input">
                            @foreach($course_types as $course_type)
                            <option value="{{$course_type->id}}" @selected($course->course_type_id==$course_type->id)>{{$course_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label>Course Code* (for compulsory only)</label>
                    <input type="text" id='code' name='code' class="custom-input" placeholder="SE-009" value="{{$course->code}}">
                </div>

                <div class="md:col-span-2">
                    <label>Full Name *</label>
                    <input type="text" id='full_name' name='name' class="custom-input" placeholder="Software Engineering" value="{{$course->name}}">
                </div>

                <div>
                    <label>Short Name <span class="text-xs">(if any, otherwise same as full name)</span></label>
                    <input type="text" id='short_name' name='short' class="custom-input" placeholder="For example: SE" value="{{$course->short}}">
                </div>
                <div>
                    <label>Pre-requisite Course</label>
                    <div class="">
                        <select name="prerequisite_course_id" id="" class="custom-input text-sm">
                            <option value="">None</option>
                            @foreach($prerequisite_courses->sortBy('name') as $prerequisite_course)
                            <option value="{{$prerequisite_course->id}}" @selected($prerequisite_course->id==$course->prerequisite_course_id)> {{ $prerequisite_course->code}} &nbsp {{$prerequisite_course->name}} &nbsp {{$prerequisite_course->lblCr() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div>
                    <label>Cr Hrs * <span class="text-xs">(Theory)</span></label>
                    <input id="" type='number' name="cr_theory" class="custom-input" placeholder="Crdit Hrs" value="{{$course->cr_theory}}" required>
                </div>
                <div>
                    <label>Cr Hrs * <span class="text-xs">(Practical)</span></label>
                    <input id="" type='number' name="cr_practical" class="custom-input" placeholder="0 if no practical" value="{{$course->cr_practical}}" min=0 required>
                </div>
                <div>
                    <label>Marks * <span class="text-xs">(Theory)</span></label>
                    <input type='number' id="" name="marks_theory" class="custom-input" placeholder="Marks" value="{{$course->marks_theory}}" min=0 required>
                </div>
                <div>
                    <label>Marks * <span class="text-xs">(Practical)</span></label>
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