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

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <!-- <div class="mt-8 bg-sky-300 text-slate-800 px-2 py-1 rounded-t-lg font-semibold">Courses Selection</div> -->

    <h1 class='text-red-600 mt-8'>{{$section->title()}}</h1>
    <div class="overflow-x-auto">
        <table class="table-fixed w-full mt-4">
            <thead>
                <tr>
                    <th class="w-24">Action</th>
                    <th class="w-32">Code</th>
                    <th class="w-96">Name</th>
                    <th class="w-32">Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($related_courses->sortBy('course_type_id') as $course)
                <tr class="tr">
                    <td>
                        @if($section->has_course($course->id))
                        <!-- dont show link btn -->
                        @else
                        <form action="{{route('courseplan.store')}}" method="POST" id='del_form' class="flex items-center justify-center">
                            @csrf
                            <input type="text" name='section_id' value="{{$section->id}}" hidden>
                            <input type="text" name='course_id' value="{{$course->id}}" hidden>
                            <input type="text" name='slot_id' value="{{$slot->id}}" hidden>

                            <button type="submit" class="btn-teal py-1 flex items-center" onclick="delme()">
                                <i class="bx bx-link"></i>
                            </button>
                        </form>
                        @endif

                    </td>
                    <td class="text-center">{{$course->code}}</td>
                    <td>{{$course->name}} <span class="text-slate-500 text-xs">{{($course->lblCr())}}</span></td>
                    <td class="text-center">{{$course->course_type->name}}</td>

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