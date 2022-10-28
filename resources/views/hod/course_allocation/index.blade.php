@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Course Allocation</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Course Allocation /
        <a href="{{url('course-allocation-options')}}" class="text-orange-700 mx-2">Choose Options</a> /
        {{$section->title()}}
    </div>
</div>

<div class="container mt-12">
    <div class="flex items-end">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

    </div>
    @if(session('success'))
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif

    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Semester</th>
                <th>Course</th>
                <th>Teacher</th>

            </tr>
        </thead>
        <tbody>
            @php
            if($scheme){
            $total_semesters=$scheme->program->min_duration*2;
            $semester_no;
            $roman=$roman=config('global.romans');
            }
            @endphp

            @for($semester_no=1;$semester_no<=$total_semesters;$semester_no++) <tr class="tr border-b">

                <td class="py-2">Semester {{$roman[$semester_no-1]}}</td>
                <td colspan='2'>
                    @foreach($scheme->scheme_details->where('semester_no',$semester_no) as $scheme_detail)
                    <!-- if compulsory -->
                    @if($scheme_detail->is_compulsory())
                    <!-- if compulsory allocation, show course name, teacher name and del btn -->
                    @if($scheme_detail->has_allocations())
                    @foreach($scheme_detail->course_allocations as $course_allocation)
                    <div class="flex items-center border-b py-2">
                        <div class="flex flex-1 text-sm">{{$scheme_detail->course->name}}</div>
                        <div class="flex flex-1 text-sm">{{$course_allocation->teacher->user->name}}</div>
                        <form action="{{route('course-allocations.destroy',$course_allocation)}}" method="POST" id='del_elective_form{{$course_allocation->id}}' class="mt-1 justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0 text-red-700" onclick="delElective('{{$course_allocation->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach

                    @else
                    <!-- no compulsory allocation, show assign btn -->
                    <div class="flex items-center border-b py-2">
                        <div class="flex flex-1 text-sm">{{$scheme_detail->course->name}}</div>
                        <a href="{{route('course-allocations.edit', $scheme_detail)}}" class="text-indigo-600 flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                            </svg>
                        </a>
                    </div>
                    @endif

                    @else
                    <!-- if optional course -->
                    @if($scheme_detail->has_allocations())
                    <!-- if allocation, show coures del btn -->

                    @foreach($scheme_detail->course_allocations as $course_allocation)

                    <div class="flex items-center border-b py-2">
                        <div class="flex flex-1 text-sm">{{$course_allocation->course->name}} ({{$scheme_detail->course->name}})</div>
                        <div class="flex flex-1 text-sm">{{$course_allocation->teacher->user->name}}</div>
                        <form action="{{route('course-allocations.destroy',$course_allocation)}}" method="POST" id='del_elective_form{{$course_allocation->id}}' class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0 text-red-700" onclick="delElective('{{$course_allocation->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach

                    @endif
                    <!-- no allocation, show course name assign btn -->
                    <div class="flex items-center border-b py-2">
                        <div class="flex flex-1 text-sm text-slate-400">Add {{$scheme_detail->course->name}}</div>
                        <a href="{{route('elective-allocations.edit', $scheme_detail)}}" class="text-indigo-600 flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                            </svg>

                        </a>
                    </div>
                    @endif
                    @endforeach
                </td>

                </tr>
                @endfor
        </tbody>
    </table>
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

    function delElective(formid) {

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
                $('#del_elective_form' + formid).submit();
            }
        });
    }

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection