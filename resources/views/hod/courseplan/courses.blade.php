@extends('layouts.hod')
@section('page-content')

<h1 class="mt-12"><a href="{{url('courseplan')}}">Course Plan</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">{{$section->title()}} / <span class="font-bold pl-1">add course</span> </div>
</div>


<!-- search box -->
<div class="flex items-end mt-16">
    <div class="flex relative ">
        <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>

</div>

<!-- courses list by default hidden -->

<table class="table-auto w-full mt-8" id='courses_list'>
    <thead>
        <tr class="border-b border-slate-200">
            <th>Semester</th>
            <th>Course</th>

        </tr>
    </thead>
    <tbody>
        @php $roman = config('global.romans'); @endphp

        @foreach($section->clas->program->semester_nos() as $semester_no)
        <tr class="tr">
            <td>Semester {{$roman[$semester_no-1]}}</td>
            <td>
                @foreach($section->clas->scheme->scheme_details->where('semester_no',$semester_no) as $scheme_detail)

                <div class="flex items-center justify-between  even:bg-slate-100">
                    <div class="text-sm py-2">{{$scheme_detail->course->name}}</div>
                    <!-- if compulsory subject, then fine, else jump to specific optional subjects page   -->

                    @if($scheme_detail->course->course_type_id==1)
                    @if($section->has_course($scheme_detail->course->id))
                    @else
                    <form action="{{route('courseplan.store')}}" method="POST" id='del_form{{$scheme_detail->id}}' class="mt-1">
                        @csrf
                        <input type="text" name='scheme_detail_id' value="{{$scheme_detail->id}}" hidden>
                        <input type="text" name='section_id' value="{{$section->id}}" hidden>
                        <input type="text" name='course_id' value="{{$scheme_detail->course_id}}" hidden>
                        <input type="text" name='semester_no' value="{{$section->clas->semester_no}}" hidden>

                        <button type="submit" class="bg-transparent p-0 border-0 text-indigo-600" onclick="delme('{{$scheme_detail->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                        </button>
                    </form>
                    @endif
                    @else
                    <a href="{{route('courseplan.optional',[$section, $scheme_detail])}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                    </a>
                    @endif
                </div>
                @endforeach

            </td>
        </tr>

        @endforeach

    </tbody>
</table>

</div>
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
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