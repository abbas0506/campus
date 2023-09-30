@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Course Selection</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('courseplan')}}">Course Allocation</a>
        <div>/</div>
        <div>Courses</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <h1 class='text-red-600 mt-8'>{{$course_allocation->section->title()}}</h1>
    <h2 class='mt-4'>Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</h2>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="overflow-x-auto">
        <table class="table-fixed w-full mt-4">
            <thead>
                <tr>
                    <th class="w-24">Action</th>
                    <th class="w-32">Code</th>
                    <th class="w-96">Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr class="tr">
                    <td>
                        @if($course_allocation->section->has_course($course->id))
                        <!-- dont show link btn -->
                        @else
                        <form action="{{route('courseplan.update',$course_allocation)}}" method="POST" id='del_form' class="flex items-center justify-center">
                            @csrf
                            @method('PATCH')
                            <input type="text" name='course_id' value="{{$course->id}}" hidden>
                            <button type="submit" class="btn-teal py-1 flex items-center" onclick="delme()">
                                <i class="bx bx-link"></i>
                            </button>
                        </form>
                        @endif

                    </td>
                    <td>{{$course->code}}</td>
                    <td class="text-left">{{$course->name}} <span class="text-slate-500 text-xs">{{($course->lblCr())}}</span></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
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
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
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