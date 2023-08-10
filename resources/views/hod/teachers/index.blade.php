@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Teachers</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Teachers</div>
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

    <div class="flex flex-wrap items-center justify-between mt-4">
        <div class="text-sm  text-gray-500">{{$teachers->count()}} records found</div>
        <a href="{{route('teachers.create')}}" class="btn-indigo">
            Add New
        </a>
    </div>


    <div class="overflow-x-auto mt-4 w-full">
        <table class="table-fixed borderless w-full">
            <thead>
                <tr>
                    <th class="w-64 text-left">Teacher</th>
                    <th class="w-32">Phone</th>
                    <th class='w-24'>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers->sortByDesc('id') as $teacher)
                <tr class="tr">
                    <td>{{$teacher->name}}</td>
                    <td class="text-center">{{$teacher->phone}}</td>
                    <td class="flex justify-center w-24 shrink-0">
                        <div class="flex items-center space-x-3 justify-center">
                            <a href="{{route('teachers.edit', $teacher)}}">
                                <i class="bi-pencil-square"></i>
                            </a>
                            @role('super')
                            <form action="{{route('teachers.destroy',$teacher)}}" method="POST" id='del_form{{$teacher->id}}' class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent p-0 border-0 text-red-600" onclick="delme('{{$teacher->id}}')" @disabled($teacher->hasRole('hod'))>
                                    <div class="bi-trash3 text-sm"></div>
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
@endsection
@section('script')
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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection