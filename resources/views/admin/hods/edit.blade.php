@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{url('hods')}}">
                HODs
            </a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Assign</span>
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

    <div class="mb-4 text-lg">{{$selected_department->name}}</div>
    <a href="{{route('departmenthods.create')}}" class="flex items-center justify-center text-gray-600 border border-indigo-600 bg-indigo-100 hover:bg-indigo-200 mt-8 mb-5 p-4 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
        </svg>
        <span class="font-bold">Desired Person Not in List !</span><span class="ml-1">Click Me</span>
    </a>
    <div class="flex items-end">
        <div class="flex flex-1 relative ">
            <input type="text" placeholder="Type here to search by name or cnic" class="search-indigo w-full" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <div class="flex flex-col ml-8">
            <label for="" class="text-sm text-gray-400">Filter</label>
            <select name="department_id" id="department_filter" class="input-indigo p-2" onchange="filter()">
                <option value="">Click here</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Name</th>
                <th>From</th>
                <th class="py-2 text-gray-600 justify-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers->sortByDesc('id') as $teacher)
            <tr class="border-b tr">
                <td class="py-2">
                    <div>{{$teacher->user->name}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$teacher->cnic}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$teacher->user->email}}</div>
                </td>
                <td class="py-2 text-sm text-gray-500 font-medium">
                    <div>{{$teacher->department->name}}</div>
                </td>
                <td class="py-2 flex items-center justify-center">
                    <form action="{{route('departmenthods.update', $teacher)}}" method="POST" id='assign_form{{$teacher->id}}' class="mt-2 text-sm">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="flex bg-green-200 text-green-800 px-3 py-2 rounded" onclick="assign('{{$teacher->id}}')">
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
            text: "You wont to assign HOD!",
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