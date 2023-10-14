@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Semester Plan</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.semester-plan.show', $course_allocation->section_id)}}">{{$course_allocation->section->title()}}</a>
        <div>/</div>
        <div>Slot # {{$course_allocation->slot_option->slot->slot_no}}</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-red-600'>{{$course_allocation->section->title()}} </h2>
        <p class="text-slate-600 text-sm">Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 mt-4">
        <div class="flex items-center justify-between border border-dashed bg-white p-4">
            <div>
                <label for="" class="text-xs">Course</label>
                <div class="flex flex-wrap">
                    <div class="w-24">{{$course_allocation->course->code }}</div>
                    <div class="">{{$course_allocation->course->name }} <span class="text-slate-400 text-xs">{{ $course_allocation->course->lblCr() }}</span></div>
                </div>
            </div>
            <div class="flex justify-center items-center bg-slate-200 flex-shrink-0 w-12 h-12 rounded-full">
                @if(Auth::user()->hasRole('super') || !$course_allocation->first_attempts()->exists())
                <form action="{{route('hod.course-allocations.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                        <i class="bx bx-trash hover:text-red-600"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="relative border border-dashed bg-white p-4">
            <a href="{{route('hod.course-allocations.teachers',$course_allocation)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
            <label for="" class="text-xs">Allocated Teacher</label>
            @if($course_allocation->teacher()->exists())
            <div>{{$course_allocation->teacher->name }}</div>
            @else
            <div class="text-slate-400 text-xs">(blank)</div>
            @endif
        </div>

    </div>

    <!-- enrollment -->
    <div class="p-4 border border-dashed bg-white relative mt-4">
        <label for="" class="text-xs">Enrollment</label>
        @if($course_allocation->teacher()->exists())
        <div class="flex items-center gap-x-4">
            <div> <a href="{{route('hod.course-allocations.enrollment.fresh', $course_allocation)}}" class="link">Fresh</a> <span class="text-slate-400 ml-2">({{$course_allocation->first_attempts->count()}})</span></div>
            <div>|</div>
            <div><a href="{{route('hod.course-allocations.enrollment.reappear', $course_allocation)}}" class="link">Reappear</a><span class="text-slate-400 ml-2">({{$course_allocation->reappears->count()}})</span></div>
        </div>
        @else
        <div class="text-slate-400 text-xs">(blank)</div>
        @endif
    </div>
    @if($course_allocation->first_attempts()->exists()||$course_allocation->reappears()->exists())
    <div class="overflow-x-auto w-full">
        <table class="table-fixed w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="w-8">Sr</th>
                    <th class="w-8"></th>
                    <th class="w-60">Name</th>
                    <th class="w-48">Father</th>
                    <th class="w-24">Status</th>
                    <th class='text-center w-24'>Remove</th>
                </tr>
            </thead>
            <tbody>
                @php $sr=1; @endphp
                @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                <tr class="tr">
                    <td>{{$sr++}}</td>
                    <td>@if($first_attempt->student->gender=='M')
                        <i class="bx bx-male text-teal-600 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif
                    </td>
                    <td>
                        <div class="text-left">{{$first_attempt->student->name}}</div>
                        <div class="text-slate-600 text-left text-sm">
                            {{$first_attempt->student->rollno}}
                        </div>
                    </td>
                    <td hidden>{{$first_attempt->student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$first_attempt->student->father}}
                    </td>
                    <td class="text-center">Fresh</td>

                    <td>
                        <form action="{{route('hod.course-allocations.enrollment.fresh.destroy',$first_attempt)}}" method="POST" id='del_fresh_form{{$first_attempt->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del_fresh('{{$first_attempt->id}}')">
                                <i class="bi bi-person-dash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <!-- reappears -->
                @foreach($course_allocation->reappears_sorted() as $reappear)
                <tr class="tr">
                    <td>{{$sr++}}</td>
                    <td>@if($reappear->first_attempt->student->gender=='M')
                        <i class="bx bx-male text-teal-600 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif
                    </td>
                    <td>
                        <div class="text-left">{{$reappear->first_attempt->student->name}}</div>
                        <div class="text-slate-600 text-left text-sm">
                            {{$reappear->first_attempt->student->rollno}}
                        </div>
                    </td>
                    <td hidden>{{$reappear->first_attempt->student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$reappear->first_attempt->student->father}}
                    </td>
                    <td>Reappear</td>
                    <td>
                        <div class="flex justify-center items-center py-2">
                            <form action="{{route('hod.course-allocations.enrollment.reappear.destroy',$reappear)}}" method="POST" id='del_reappear_form{{$reappear->id}}' class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del_reappear('{{$reappear->id}}')">
                                    <i class="bi bi-person-dash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
@section('script')
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

    function del_fresh(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_fresh_form' + formid).submit();
            }
        });
    }

    function del_reappear(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_reappear_form' + formid).submit();
            }
        });
    }
</script>
@endsection