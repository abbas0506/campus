@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('courseplan')}}">Course Allocation | Step IV-A</a></h1>
<div class="bread-crumb">
    <span class="text-slate-400">{{$course_allocation->section->title()}}</span>
    -- {{$course_allocation->course->name}} / Replace teacher
</div>


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

    <!-- records found -->
    <div class="flex items-center mt-4 mb-2">

        <div class=" bg-teal-100 text-slate-800 px-2"><span class="bx bx-group px-2"></span>Available Teachers: ({{$teachers->count()}})</div>
    </div>


    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Teacher / CNIC</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers->sortBy('name') as $teacher)
            <tr class="tr">
                <td>
                    <div class="text-slate-800">{{$teacher->name}}</div>
                    <div class="text-sm text-gray-500">{{$teacher->cnic}}</div>
                </td>
                <td>
                    <div class="text-sm text-gray-500">{{$teacher->email}}</div>
                </td>
                <td>
                    <form action="{{route('courseplan.replace.teacher')}}" method="POST" id='assign_form{{$teacher->id}}' class="flex items-center justify-center">
                        @csrf
                        @method('POST')

                        <input type="text" name='teacher_id' value="{{$teacher->id}}" hidden>
                        <input type="text" name='course_allocation_id' value="{{$course_allocation->id}}" hidden>
                        <button type="submit" class="btn-teal py-0" onclick="replace('{{$teacher->id}}')"><i class="bx bx-link"></i></button>
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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    // function filter() {
    //     var searchtext = $('#department_filter option:selected').text().toLowerCase();
    //     $('.tr').each(function() {
    //         if (!(
    //                 $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
    //                 $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
    //             )) {
    //             $(this).addClass('hidden');
    //         } else {
    //             $(this).removeClass('hidden');
    //         }
    //     });
    // }

    function replace(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Teacher will be replaced permanently!",
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