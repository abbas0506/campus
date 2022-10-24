@extends('layouts.hod')
@section('page-content')

<h1 class="mt-5">Schemes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('schemes.index')}}" class="text-orange-700">
            Schemes
        </a>
        / {{session('scheme')->semester->title()}}
        / {{session('scheme')->program->short}}
        / Semester {{session('semester_no')}}
    </div>
</div>

<div class="container md:w-3/4 mx-auto px-5 md:px-0">

    @if ($errors->any())
    <div class="alert-danger mt-5">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex items-end mt-8">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

    </div>

    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Course Name</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->sortByDesc('id') as $course)
            <tr class="border-b tr">
                <td class="py-2">
                    <div>{{$course->name}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$course->code}}</div>
                    <div class="text-sm text-gray-500 font-medium">({{$course->credit_hrs_theory}}-{{$course->credit_hrs_practical}})</div>

                </td>
                <td class="py-2 flex items-center justify-center">
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="mt-2 text-sm">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex flex-col justify-center items-center btn-indigo" onclick="assign('{{$course->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            assign
                        </button>
                    </form>
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