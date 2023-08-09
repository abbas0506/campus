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

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="mt-8 bg-sky-300 text-slate-800 px-2 py-1 rounded-t-lg font-semibold">Courses Selection</div>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="text-sm">
                <th class="text-left">Code</th>
                <th class="text-left">Type</th>
                <th class="text-left">Name</th>
                <th class="text-left">Cr. hr</th>

                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->get()->sortBy('course_type_id') as $course)
            <tr class="tr">
                <td>{{$course->code}}</td>
                <td>{{$course->course_type->name}}</td>
                <td>{{$course->name}}</td>
                <td>{{($course->lblCr())}}</td>

                <td>
                    @if($section->has_course($course->id))
                    <!-- dont show link btn -->
                    @else
                    <form action="{{route('courseplan.store')}}" method="POST" id='del_form' class="flex items-center justify-center">
                        @csrf
                        <input type="text" name='section_id' value="{{$section->id}}" hidden>
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <input type="text" name='slot_id' value="{{$slot->id}}" hidden>

                        <button type="submit" class="btn-teal py-0 flex items-center" onclick="delme()">
                            Select
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