@extends('layouts.hod')
@section('page-content')
<div class="container px-20">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="#">
                Scheme {{session('scheme')->semester->year}}
            </a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>{{session('scheme')->program->short}}</span>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Semester {{session('semester_no')}}</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-4 text-lg"></div>
    <div class="flex items-end">
        <div class="flex flex-1 relative ">
            <input type="text" placeholder="Type here to search by name or cnic" class="search-indigo w-full" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

    </div>
    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="py-2 text-gray-600 text-left">Course Name</th>
                <th class="py-2 text-gray-600 justify-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses->sortByDesc('id') as $course)
            <tr class="border-b tr">
                <td class="py-2">
                    <div>{{$course->name}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$course->code}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$course->credit_hrs}}</div>

                </td>
                <td class="py-2 flex items-center justify-center">
                    <form action="{{route('scheme-details.store')}}" method="POST" id='assign_form{{$course->id}}' class="mt-2 text-sm">
                        @csrf
                        <input type="text" name='course_id' value="{{$course->id}}" hidden>
                        <button type="submit" class="flex bg-green-200 text-green-800 px-3 py-2 rounded" onclick="assign('{{$course->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-gray">
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