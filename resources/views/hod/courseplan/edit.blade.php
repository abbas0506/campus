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

    <div class="grid grid-cols-2 mt-8 gap-3 p-4 rounded-md border divide-y divide-x">

        <h3>Slot</h3>
        <h3>Course & Teacher</h3>
        @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo(session('semester_id')))->get()->sortBy('slot_no') as $slot)
        <div>
            <div class="grid grid-cols-2">
                <div>
                    <h3>Slot # {{$slot->slot_no}}</h3>
                </div>
                <div class="">
                    <div class="flex items-center">
                        <div class="w-8"><i class="bi-clock"></i></div>
                        <div>{{$slot->cr}}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8"><i class="bi-book"></i></div>
                        <div>{{$slot->lblCrsType()}}</div>
                    </div>

                </div>

            </div>

        </div>
        <div>

        </div>
        @endforeach
    </div>




    <div class="grid grid-cols-1 mt-8 gap-3 p-4 rounded-md border">
        @foreach($section->clas->scheme->slots()->for($section->clas->semesterNo(session('semester_id')))->get()->sortBy('slot_no') as $slot)
        <div class="border-b border-slate-200">
            <div class="flex items-center space-x-6 pb-4 border-b border-dashed">
                <div class="flex items-center justify-center w-8 h-8 bg-teal-100 ring-1 ring-teal-200 ring-offset-2 text-slate-800">{{$slot->slot_no}}</div>
                <h2 class=""><i class="bi-clock"></i> {{$slot->cr}}</h2>
                <h2>{{$slot->lblCrsType()}}</h2>
            </div>
            <div class="flex w-full py-2">
                <a href="{{route('courseplan.courses',[$section,$slot])}}" class="btn-teal flex items-center text-sm"><i class="bi-plus text-[16px] mr-2"></i> Add Course </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 px-6 pb-4 space-y-2">
                @foreach($section->course_allocations()->on($slot->id)->get() as $course_allocation)
                <div class="flex items-center justify-between pr-4 ">
                    {{$course_allocation->id}} {{$course_allocation->course->name}}
                </div>

                <div class="md:border-l md:pl-6 ">@if($course_allocation->teacher_id=='')
                    <div class="flex items-center">
                        <a href="{{route('courseplan.teachers',$course_allocation)}}">
                            <i class="bi-link-45deg text-indigo-600 text-[20px]"></i>
                        </a>
                        <div class="text-xs text-slate-400 text-thin ml-2">(Assign Teacher)</div>
                    </div>

                    @else
                    {{$course_allocation->teacher->name}}
                    @endif
                </div>
                <div class="text-right">
                    @if($course_allocation->teacher_id=='' || $course_allocation->first_attempts->count()==0)
                    <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-red pb-1 px-2 text-xs" onclick="delme('{{$course_allocation->id}}')">
                            Remove
                        </button>
                    </form>
                    @endif
                    @if($course_allocation->teacher_id!='')
                    <a href="{{route('courseplan.replace',$course_allocation->id)}}" class="btn-blue text-xs pb-1 px-2">Replace</a>
                    @endif
                </div>

                @endforeach
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