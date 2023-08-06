@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('courseplan')}}" class="link">Course Allocation</a> | Edit</h1>
<div class="flex">
    <div class="flex items-center mt-1">
        <h2 class="">{{$section->title()}}</h2>
        <i class="bi-chevron-right text-[12px] mx-1"></i>
        <h2>{{$section->clas->scheme->subtitle()}}</h2>
    </div>
</div>
<div class="container mx-auto mt-8">

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


    <div class="flex flex-col gap-y-4">
        @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo(session('semester_id')))->get()->sortBy('slot_no') as $slot)
        <div class="gap-y-4">
            <div class="bg-slate-200 px-2 py-1 rounded-t-lg">
                <div class="flex items-center">
                    <h3 class="w-24">Slot # {{$slot->slot_no}}</h3>
                    <h3>{{$slot->lblCrsType()}} ({{$slot->cr}})</h3>
                </div>
            </div>
            <div class="border border-dashed p-2">
                <div class="md:pl-24">
                    @foreach($section->course_allocations()->on($slot->id)->get() as $course_allocation)
                    <div class="flex flex-col lg:flex-row gap-2 py-1 w-full border-b">
                        <div class="flex flex-1 text-slate-800 space-x-2">
                            <div>{{$course_allocation->course->code}}</div>
                            <div class="flex-1">{{$course_allocation->course->name}}</div>
                            <div>
                                <!-- delete button -->
                                @if($course_allocation->teacher_id=='' || $course_allocation->first_attempts->count()==0)
                                <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                                        <i class="bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-1 justify-between text-slate-800">
                            <div>{{ $course_allocation->teacher->name ?? ''}}</div>
                            <div>
                                <!-- teacher -->
                                @if($course_allocation->teacher_id!='')
                                <a href="{{route('courseplan.replace',$course_allocation->id)}}" class="btn-blue text-xs pb-1 px-2">Replace</a>
                                @else
                                <a href="{{route('courseplan.teachers',$course_allocation)}}" class="flex items-center text-sm link">
                                    (Assign Teacher)
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex lg:pl-24 text-sm mt-2">
                    <a href="{{route('courseplan.courses',[$section,$slot])}}" class="bg-teal-300 px-2 flex items-center text-sm">
                        Select Course
                    </a>
                </div>
            </div>

        </div>

        @endforeach
    </div>
</div>
<script type="text/javascript">
    function delme(formid) {

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
                $('#del_form' + formid).submit();
            }
        });
    }

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