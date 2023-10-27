@extends('layouts.admin')
@section('page-content')
<h1>Course Types</h1>
<div class="bread-crumb">Courese Types / all</div>

<div class="container w-fullmx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative w-60">
            <input type="text" placeholder="Search ..." class="search-indigo w-60" oninput="search(event)">
            <i class="bi bi-search absolute right-1 top-3"></i>
        </div>
        <a href="{{route('coursetypes.create')}}" class="btn-indigo text-sm">
            Add New
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

    <table class="table-fixed w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="w-8">ID</th>
                <th class="w-48">Course Type</th>
                <th class="w-16">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($coursetypes->sortBy('name') as $coursetype)
            <tr class="tr">
                <td>{{$coursetype->id}}</td>
                <td class="text-left">{{$coursetype->name}}</td>
                <td>
                    <div class="flex justify-center items-center">
                        <a href="{{route('coursetypes.edit', $coursetype)}}" class="text-teal-800">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @role('super')
                        <form action="{{route('coursetypes.destroy',$coursetype)}}" method="POST" id='del_form{{$coursetype->id}}' class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="delme('{{$coursetype->id}}')">
                                <i class="bi bi-trash3 text-xs"></i>
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
        var str = 0;
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
</script>

@endsection