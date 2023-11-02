@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>User Access Control</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <div>User Access</div>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="mt-8">
        <table class="table-auto w-full">
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
                    <td class="py-2 pl-3 text-left">
                        <a href="{{route('admin.user-access.edit',$user)}}" class="link">{{$user->name}}</a>
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
                        <a href="{{route('admin.user-access.edit', $user)}}" class="flex justify-center">
                            @if($user->is_active)
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