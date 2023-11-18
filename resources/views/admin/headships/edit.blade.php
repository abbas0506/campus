@extends('layouts.admin')
@section('page-content')

<div class="container">
    <h2>Assign/Edit Headship</h2>
    <p>{{$department->name}}</p>
    <div class="bread-crumb">
        <a href="{{route('admin.departments.show',$department)}}">Cancel & Go back</a>
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

    <div class="flex items-center flex-wrap justify-between mt-8">
        <div class="text-sm  text-gray-500 mt-4">{{$teachers->count()}} records found</div>
        <a href="{{route('admin.headships.create')}}" class="btn-indigo text-sm">
            Not in List, Create New
        </a>
    </div>

    <table class="table-auto w-full mt-3">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Teacher Name</th>
                <th>Parent Department</span> </th>
                <th class="py-2 text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr class="border-b tr">
                <td class="text-left pl-3">
                    <div>{{$teacher->name}}</div>
                    <div class="text-slate-400">{{$teacher->email}}</div>
                </td>
                <td class="text-slate-600">
                    {{Str::replace('Department of ','',$teacher->department->name)}}
                </td>
                <td>
                    <div class="flex justify-center items-center">
                        <form action="{{route('admin.headships.update', $teacher->id)}}" method="POST" id='assign_form{{$teacher->id}}' class="mt-2 text-sm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="department_id" value="{{$department->id}}">
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