@extends('layouts.hod')
@section('page-content')

<h1><a href="{{url('courseplan')}}">Course Allocation | Step III</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">{{$section->title()}} / <span class="font-bold pl-1">add course</span> </div>
</div>

<!-- search box -->
<div class="flex items-end mt-8">
    <div class="flex relative ">
        <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>

</div>

@php
$roman=config('global.romans');
@endphp
<div class="text-lg font-semibold text-teal-800 mt-8">Study Scheme: {{$section->clas->scheme->subtitle()}}</div>
<!-- courses list by default hidden -->
<div class="flex flex-col accordion mt-4">
    @foreach($section->semesters() as $semester)
    @php
    $semester_no=$section->clas->semesterNo($semester->id);
    @endphp
    <div class="collapsible">
        <div class="head active">
            <h2>Semester {{$roman[$semester->id-$section->clas->first_semester_id]}}
                <span class="bx bx-book text-slate-400 ml-6"></span>
                <span class="text-xs text-slate-600 ml-2">{{$section->clas->scheme->scheme_details()->for($semester_no)->count()}}</span>
            </h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">

            @foreach($section->clas->scheme->scheme_details()->for($semester_no)->get() as $scheme_detail)

            <div class="flex items-center w-full even:bg-slate-100 tr">

                <div class="text-sm py-2 w-32 text-center">{{$scheme_detail->course->code}}</div>
                <div class="text-sm py-2 flex-1">{{$scheme_detail->course->name}} <span class="text-slate-400 text-xs ml-4">{{$scheme_detail->course->lblCr()}}</span></div>
                <div class="text-sm py-2 w-32 font-thin">{{$scheme_detail->course->course_type->name}}</div>

                <!-- if compulsory subject, then fine, else jump to specific optional subjects page   -->
                <div class="flex justify-center items-cetner w-12">
                    @if($scheme_detail->course->course_type_id==1)
                    @if($section->has_course($scheme_detail->course->id))
                    <i class="bx bx-check-double"></i>
                    @else
                    <form action="{{route('courseplan.store')}}" method="POST" id='del_form{{$scheme_detail->id}}' class="flex items-center justify-center">
                        @csrf
                        <input type="text" name='scheme_detail_id' value="{{$scheme_detail->id}}" hidden>
                        <input type="text" name='section_id' value="{{$section->id}}" hidden>
                        <input type="text" name='course_id' value="{{$scheme_detail->course_id}}" hidden>
                        <input type="text" name='semester_no' value="{{$section->clas->semester_no}}" hidden>

                        <button type="submit" class="btn-teal py-0" onclick="delme('{{$scheme_detail->id}}')">
                            <i class="bx bx-link"></i>
                        </button>

                    </form>
                    @endif
                    @else
                    <a href="{{route('courseplan.optional',[$section, $scheme_detail])}}" class="btn-orange py-0">
                        <i class="bx bx-chevrons-right"></i>
                    </a>
                    @endif
                </div>


            </div>
            @endforeach

        </div>

    </div>

    @endforeach
</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function assign(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Course will be added to scheme !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form

                $('#assign_form' + formid).submit();
            }
        });
    }

    function dispaly_teachers_list() {
        $("#courses_list").addClass('hidden');
        $("#teachers_list").removeClass('hidden');

        window.scrollTo({
            top: $("#teachers_list").height(),
            behavior: 'smooth'
        })
    }

    function displayCourseList() {
        $("#teachers_list").addClass('hidden');
        $("#courses_list").removeClass('hidden');

        window.scrollTo({
            top: $("#courses_list").height(),
            behavior: 'smooth'
        })
    }

    function assignCourse(id, name) {
        $('#course_id').val(id);
        $('#course_label').html(name);

        if ($('#teacher_id').val()) {
            if ($('#submit').hasClass('cursor-not-allowed')) {
                $('#submit').removeClass('cursor-not-allowed')
            }
            $('#submit').removeAttr('disabled');
        }

        $("#courses_list").toggleClass('hidden');

    }

    function assignTeacher(id, name) {
        $('#teacher_id').val(id);
        $('#teacher_label').html(name);

        if ($('#course_id').val()) {
            if ($('#submit').hasClass('cursor-not-allowed')) {
                $('#submit').removeClass('cursor-not-allowed')
            }
            $('#submit').removeAttr('disabled');
        }
        $("#teachers_list").toggleClass('hidden');

    }
</script>
@endsection