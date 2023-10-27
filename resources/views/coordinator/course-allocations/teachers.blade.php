@extends('layouts.coordinator')
@section('page-content')
<div class="container">
    <h2>Teacher Allocation</h2>
    <div class="bread-crumb">
        <a href="{{route('coordinator.semester-plan.show', $course_allocation->section)}}">Cancel & Go Back</a>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="mt-8 border border-dashed p-4">
        <div class="flex items-center justify-center space-x-4 ">
            <h2 class='text-red-600'>{{$course_allocation->section->title()}}</h2>
            <p class="text-slate-600 text-sm">Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</p>
        </div>
        <h2 class="text-center mt-1">{{$course_allocation->course->name ?? ''}}</h2>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="overflow-x-auto mt-8">
        <label>{{$teachers->count()}} records in view</label>
        <table class="table-fixed w-full mt-1">
            <thead>
                <tr>
                    <th class="w-16">Action</th>
                    <th class="w-48">Teacher Name</th>
                    <th class="w-16">Type</th>
                    <th class="w-32">Phone/CNIC</th>
                    <th class="w-48">Department</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers->sortBy('name') as $teacher)
                <tr class="tr">
                    <td>
                        <form action="{{route('coordinator.course-allocations.update', $course_allocation->id)}}" method="POST" id='assign_form{{$teacher->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('PATCH')
                            <input type="text" name='teacher_id' value="{{$teacher->id}}" hidden>
                            <button type="submit" class="btn-teal py-0" onclick="assign('{{$teacher->id}}')">
                                <i class="bx bx-link"></i>
                            </button>
                        </form>
                    </td>
                    <td class="text-left">{{$teacher->name}}</td>
                    <td>@if($teacher->is_regular) Regular @else Visitor @endif</td>
                    <td class="text-left">{{$teacher->phone}}<br><span class="text-slate-400">{{$teacher->cnic}}</span></td>
                    <td class="text-left">{{Str::replace('Department of ','',$teacher->department->name)}}</td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
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
            text: "Teacher will be allocated!",
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