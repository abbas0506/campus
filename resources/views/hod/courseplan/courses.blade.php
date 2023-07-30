@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('courseplan')}}">Course Allocation | Step III-A</a></h1>

<div class="container mx-auto mt-8">

    <div class="flex items-end">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

    </div>

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif

    <div class="flex w-full mt-8">
        <span class="bg-teal-100 px-3 py-1">Courses</span>
    </div>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->get()->sortBy('code') as $course)
            <tr class="tr">
                <td class="text-center">{{$course->code}}</td>
                <td>{{$course->name}}</td>
                <td class="text-center">{{$course->course_type->name}}</td>

                <td class="">
                    @if($section->has_course($course->id))
                    <!-- dont show link btn -->
                    @else
                    <form action="{{route('courseplan.store')}}" method="POST" id='del_form' class="py-2 flex items-center justify-center">
                        @csrf
                        <input type="text" name='section_id' value="{{$section->id}}" hidden>
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <input type="text" name='slot_id' value="{{$slot->id}}" hidden>

                        <button type="submit" class="btn-teal py-0" onclick="delme()">
                            <i class="bx bx-link"></i>
                        </button>
                    </form>
                    @endif

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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function filter() {
        var searchtext = $('#department_filter option:selected').text().toLowerCase();
        $('.tr').each(function() {
            if (!(
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
</script>
@endsection