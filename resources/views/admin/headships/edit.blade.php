@extends('layouts.admin')
@section('page-content')
<h1><a href="{{route('departments.index')}}">Deptt & Headship</a></h1>
<div class="bread-crumb">{{$selected_department->name}} / assign hod</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" id='search_input' placeholder="Search ..." class="search-indigo" oninput="search()">
            <i class="bi bi-search absolute right-1 top-3"></i>
        </div>
        <a href="{{route('headships.create')}}" class="btn-indigo text-sm">
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

<div class="text-sm  text-gray-500 mt-8">{{$teachers->count()}} records found</div>
<table class="table-auto w-full mt-3">
    <thead>
        <tr class="border-b border-slate-200">
            <th>Teacher Name</th>
            <th>Department <span class="text-sm text-orange-700 font-thin">( basic )</span> </th>
            <th class="py-2 text-gray-600 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
        <tr class="border-b tr">
            <td class="py-2">
                <div>{{$teacher->name}}</div>
                <div class="text-sm text-slate-400">{{$teacher->email}}</div>
            </td>
            <td class="py-2 text-sm text-slate-600">
                <div>{{Str::replace('Department of ','',$teacher->department->name)}}</div>
            </td>
            <td>
                <div class="flex justify-center items-center">
                    <form action="{{route('headships.update', $teacher->id)}}" method="POST" id='assign_form{{$teacher->id}}' class="mt-2 text-sm">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="department_id" value="{{$selected_department->id}}">
                        <button type="submit" class="text-blue-600" onclick="assign('{{$teacher->id}}')">
                            <i class=" bi bi-paperclip"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
<script type="text/javascript">
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