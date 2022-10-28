@extends('layouts.hod')
@section('page-content')

<h1 class="mt-5">Course Allocation</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Course Allocation /
        <a href="{{url('course-allocation-options')}}" class="text-orange-700 mx-1">choose options</a> /
        <a href="{{route('course-allocations.index')}}" class="text-orange-700 mx-1">course allocations</a> /
        {{$scheme_detail->course->name}}

        / assign teacher
    </div>
</div>

<div class="flex space-x-8 mt-12 ">
    <div class="p-5 w-1/2 bg-slate-100">
        <h2>Read Me</h2>
        <ul class="list-disc text-sm text-slate-500 ml-8 leading-relaxed">
            <li>Basically, you are going to choose an elective course and then assign a teacher from available list </li>
            <li>To choose course, click on edit icon before courses. Courses list will appear. Click on the desired course</li>
            <li>To assign teacher, click on edit icon before teachers. Teachers list will appear. Click on the desired teacher </li>
            <li>Remember, submit button will remain disabled untill you choose both of them.</li>

        </ul>
    </div>
    <div class="md:w-1/2 rounded md:mt-0 mt-12">

        <form action="{{route('course-allocations.store')}}" method='post' class="flex flex-col border border-rounded">
            @csrf
            <input type="text" id='' name='scheme_detail_id' value='{{$scheme_detail->id}}' hidden>
            <input type="text" id='course_id' name='course_id' value='' hidden>
            <input type="text" id='teacher_id' name='teacher_id' value='' hidden>

            <div class="flex flex-col p-8">
                <div class="flex cursor-pointer items-center justify-between w-full mt-5" onclick="displayCourseList()">

                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <label for="" class="mr-3" id='course_label'>Please select a course</label>
                    <a class="flex items-center justify-between text-green-800 hover:text-indigo-600 px-3 py-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </a>
                </div>

                <div class="border-b border-slate-300 w-full my-4"></div>
                <div class="flex items-center justify-between w-full">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <label for="" class="mr-3" id='teacher_label'>Please select a teacher</label>
                    <a class="flex items-center justify-between cursor-pointer  text-green-800 hover:text-indigo-600 px-3 py-2 rounded" onclick="dispaly_teachers_list()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </a>

                </div>
                <div class="border-b border-slate-300 w-full mt-4"></div>
                <div class="flex md:space-x-4 justify-end mt-8">
                    <a href="{{url('hod')}}" class="flex justify-center btn-indigo">Cancel</a>
                    <button type="submit" id='submit' class="flex justify-center btn-indigo cursor-not-allowed disabled:bg-indigo-300" disabled>Submit</button>
                </div>
            </div>
        </form>

    </div>

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

<table class="table-auto w-full mt-8 hidden" id='courses_list'>
    <thead>
        <tr class="border-b border-slate-200">
            <th>Course</th>
            <th class="flex justify-center">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach($courses as $course)
        <tr class="border-b tr">
            <td class="py-2">
                <div>{{$course->name}}</div>
            </td>
            <td class="flex items-center justify-center py-2">
                <button type='button' class="flex cursor-pointer btn-indigo" onclick="assignCourse('{{$course->id}}','{{$course->name}}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                    </svg>
                </button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<!-- teachers list by default hidden-->

<table class="table-auto w-full mt-8 hidden" id='teachers_list'>
    <thead>
        <tr class="border-b border-slate-200">
            <th>Teacher</th>
            <th class="flex justify-center">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach($teachers->sortByDesc('id') as $teacher)
        <tr class="border-b tr">
            <td class="py-2">
                <div>{{$teacher->user->name}}</div>
                <div class="text-sm text-gray-500 font-medium">{{$teacher->cnic}}</div>
                <div class="text-sm text-gray-500 font-medium">{{$teacher->user->email}}</div>

            </td>
            <td class="flex items-center justify-center py-2">

                <button class="flex flex-col justify-center items-center cursor:pointer btn-indigo" onclick="assignTeacher('{{$teacher->id}}','{{$teacher->user->name}}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                    </svg>
                    assign
                </button>

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