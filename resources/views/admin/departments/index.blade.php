@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Departments</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <div>Departments</div>
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

    <div class="flex justify-between items-center">
        <div class="text-sm mt-8">{{$departments->count()}} departments found</div>
        <a href="{{route('admin.departments.create')}}" class="btn-indigo text-sm">Add New Deptt</a>
    </div>


    <table class="table-auto w-full mt-2">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Sr</th>
                <th>Full Name/Degree Title</th>
                <th>HoD</th>
                @role('super')
                <th></th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @php $sr=1; @endphp
            @foreach($departments->sortByDesc('updated_at') as $department)
            <tr class="tr border-b">
                <td>{{$sr++}}</td>
                <td class="text-left pl-3">
                    <a href="{{route('admin.departments.show', $department)}}" class="link">{{$department->name}}</a><br>
                    {{$department->title}}
                </td>
                <td>
                    @if($department->headship)
                    <div>{{$department->headship->user->name}}</div>
                    <div class="text-sm text-slate-400">{{$department->headship->user->email}}</div>
                    <div class="text-sm text-slate-400">{{$department->headship->department->name}}</div>
                    @endif
                </td>

                @role('super')
                <td>
                    <form action="{{route('admin.departments.destroy',$department)}}" method="POST" id='del_form{{$department->id}}'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600" onclick="delme('{{$department->id}}')">
                            <i class="bi bi-trash3 text-xs"></i>
                        </button>
                    </form>
                </td>
                @endrole
                s
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
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection