@extends('layouts.admin')
@section('page-content')
<h1>User Access</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Users / all
    </div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
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

    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th>User Name</th>
                <th>Parent Department</th>
                <th>Role(s)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach($users->sortBy(['status','name']) as $user)
            <tr class="tr border-b">
                <td class="py-2">
                    <a href="{{route('user-access.edit',$user)}}" class="link">{{$user->name}}</a>
                    <div class="text-sm text-slate-600">{{$user->email}}</div>
                </td>
                <td class="text-slate-600 text-sm">{{Str::replace('Department of ','',$user->department->name)}}</td>
                <td class="text-sm text-center text-slate-600">
                    <ul class="">
                        @foreach($user->roles as $role)
                        <li class="capitalize">{{$role->name}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{route('user-access.edit', $user)}}" class="flex justify-center">
                        @if($user->status==1)
                        <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                        @else
                        <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                        @endif
                    </a>

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
            text: "You won't be able to revert this! Everything related to this person will be erased at all",
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