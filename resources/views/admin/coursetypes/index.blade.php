@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Departments</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <div>Departments</div>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif


    <div class="mt-8">
        <div class="flex items-center flex-wrap justify-between">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3 mt-8">
                <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>
            <a href="{{route('admin.coursetypes.create')}}" class="btn-indigo text-sm">
                Add New
            </a>
        </div>
        @php $sr=1; @endphp
        <table class="table-fixed w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="w-8">Sr</th>
                    <th class="w-48">Course Type</th>
                    <th class="w-16">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($coursetypes->sortByDesc('updated_at') as $coursetype)
                <tr class="tr">
                    <td>{{$sr++}}</td>
                    <td class="text-left">{{$coursetype->name}}</td>
                    <td>
                        <div class="flex justify-center items-center">
                            <a href="{{route('admin.coursetypes.edit', $coursetype)}}" class="text-teal-800">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @role('super')
                            <form action="{{route('admin.coursetypes.destroy',$coursetype)}}" method="POST" id='del_form{{$coursetype->id}}' class="ml-2">
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