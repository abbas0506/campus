@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12"><a href="{{route('departments.index')}}">Deptt & Headship</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$selected_department->name}} / assign hod
    </div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" id='search_input' placeholder="Search ..." class="search-indigo" oninput="search()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <div class="flex relative">
            <select name="department_id" id="department_filter" class="input-indigo py-1" onchange="search()">
                <option value="">No filter</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute -right-6 top-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>

        </div>
        <a href="{{route('headship.create')}}" class="btn-indigo text-sm">
            Create & Assign New
        </a>
    </div>
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
</div>
<table class="table-auto w-full mt-8">
    <thead>
        <tr class="border-b border-slate-200">
            <th>User Name</th>
            <th>Department <span class="text-sm text-orange-700 font-thin">( basic )</span> </th>
            <th class="py-2 text-gray-600 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class="border-b tr">
            <td class="py-2">
                <div>{{$user->name}}</div>
                <div class="text-sm text-gray-500 font-medium">{{$user->cnic}}</div>
                <div class="text-sm text-gray-500 font-medium">{{$user->email}}</div>
            </td>
            <td class="py-2 text-sm text-gray-500 font-medium">
                <div>{{$user->department->name}}</div>
            </td>
            <td class="py-2 flex items-center justify-center">
                <form action="{{route('headship.update', $user)}}" method="POST" id='assign_form{{$user->id}}' class="mt-2 text-sm">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="flex bg-green-200 text-green-800 px-3 py-2 rounded" onclick="assign('{{$user->id}}')">
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
    function search() {
        // var searchtext = event.target.value.toLowerCase();
        var searchtext = $('#search_input').val().toLowerCase();
        var filtertext = $('#department_filter option:selected').text().toLowerCase();
        if (filtertext == 'no filter') {
            $('.tr').each(function() {
                //dont filter
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        } else {
            //apply filter
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) &&
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(filtertext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }


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