@extends('layouts.hod')
@section('page-content')
<h1 class="mt-5">Course Allocation</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{url('course-allocation-options')}}" class="text-orange-700 mr-2">Choose Options</a> /
        assign / teachers
        <span class="text-sm text-teal-700 ml-8 font-thin"> [ Step 3 / 3 ]</span>
    </div>
</div>

<div class="container mx-auto mt-12">

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
                <th>Teacher <span class="text-sm text-slate-600 font-thin">({{$teachers->count()}} rows found)</span></th>
                <th class="py-2 flex text-gray-600 justify-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr class="border-b tr">
                <td class="py-2">
                    <div>{{$teacher->user->name}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$teacher->cnic}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$teacher->user->email}}</div>
                </td>
                <td class="py-2 flex items-center justify-center">
                    <form action="{{url('course-allocations/assign/teacher')}}" method="POST" id='assign_form{{$teacher->id}}' class="mt-2 text-sm">
                        @csrf
                        @method('PATCH')
                        <input type="text" name='teacher_id' value="{{$teacher->id}}" hidden>
                        <button type="submit" class="flex flex-col items-center justify-center btn-indigo" onclick="assign('{{$teacher->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
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