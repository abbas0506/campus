@extends('layouts.hod')
@section('page-content')

<h1>Courses</h1>
<div class="bread-crumb">Courses / all</div>
<div class="flex items-center justify-between flex-wrap mt-4">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
    <a href="{{route('courses.create')}}" class="btn-indigo">
        Add New
    </a>
</div>

<div class="container mt-6">
    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif

    <div class="flex flex-wrap items-center space-x-2 text-sm mb-2">
        <div class="relative">
            <label id='lbl_all' class="checked-label active" onclick="filter(event)">
                <i class="bx bx-book mr-1"></i>
                {{$courses->count()}}
            </label>
            <span class="bullet"></span>
        </div>

        @foreach($course_types as $course_type)
        <div class="relative">
            <label id='lbl_{{$course_type->id}}' class="checked-label" onclick="filter(event)">
                {{$course_type->name}}: <span class="ml-1"></span>{{$course_type->courses()->type($course_type->id)->deptt(session('department')->id)->count()}}
            </label>
            <div class="bullet"></div>
        </div>
        @endforeach
    </div>


    <table class="table-auto w-full">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Code</th>
                <th>Course Name</th>
                <th class="text-center">Type</th>
                <th class="text-center">Cr Hrs.</th>
                <th class="text-center">Marks</th>
                <th class='text-center'>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($courses->sortByDesc('id') as $course)
            <tr class="tr border-b ">
                <td class="text-center">{{$course->code}}</td>
                <td class="">
                    <div>{{$course->name}}</div>
                    <div class="text-slate-400">{{$course->short}}</div>
                </td>
                <td class="hidden">{{$course->course_type->id}}</td>
                <td class="text-center">{{$course->course_type->name}}</td>

                <td class="text-center">{{$course->creditHrsLabel()}}</td>
                <td class="text-center">
                    {{$course->marks_theory}} + {{$course->marks_practical}}
                </td>

                <td>
                    <div class="flex justify-center items-center space-x-3">
                        <a href="{{route('courses.edit', $course)}}">
                            <i class="bi bi-pencil-square text-green-600"></i>
                        </a>
                        @role('super')
                        <form action="{{route('courses.destroy',$course)}}" method="POST" id='del_form{{$course->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$course->id}}')">
                                <i class="bi bi-trash3 text-red-600"></i>
                            </button>
                        </form>
                        @endrole
                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

@endsection
@section('script')
<script>
    //code here
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

    function filter(event) {
        var searchtext = event.target.id.replace('lbl_', '');
        $('.checked-label').each(function() {
            if ($(this).attr('id') != event.target.id)
                $(this).removeClass('active')
            else {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active')
                }
            }
        });


        if (searchtext == 'all') {
            //remove filter
            $('.tr').each(function() {
                $(this).removeClass('hidden');
            });
        } else {
            //apply filter
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)

                    )) {
                    $(this).addClass('hidden');

                } else {
                    $(this).removeClass('hidden');
                    console.log(searchtext + ',')
                }

            });
        }
    }

    // $(".checked-label").click(function() {
    //     $(this).toggleClass("active");
    // });
</script>

@endsection