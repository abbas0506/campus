@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Class & Sections</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('clases')}}">Classes & Sections</a>
        <div>/</div>
        <div>View</div>
    </div>

    <div class="flex mt-8">
        <div class="relative">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <i class="bi-search absolute top-2 right-1"></i>
        </div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap items-center justify-between text-slate-600 gap-4 mt-8">
        <div class="flex items-center space-x-4">
            <div class="flex items-center bg-teal-300 px-2">
                <i class="bx bx-male-female mr-2"></i>{{$section->students->count()}}
            </div>
            <i class="bx bx-chevrons-right"></i>
            <div class="flex items-center">
                <i class="bx bx-male"></i>{{$section->students()->gender(1)->count()}}
            </div>
            <div class="flex items-center">
                <i class="bx bx-female"></i>{{$section->students()->gender(2)->count()}}
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{route('students.add', $section)}}" class="btn-indigo flex items-center">
                <i class="bi bi-person-add"></i>
                <span class="hidden md:flex ml-2">Manual Feed</span>
            </a>
            <a href="{{route('students.excel', $section)}}" class="btn-teal flex items-center">
                <i class="bi bi-upload"></i>
                <span class="hidden md:flex ml-2">From Excel</span>
            </a>
            @role('super')
            <form action="{{route('sections.destroy',$section)}}" method="POST" id='del_form{{$section->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-red flex items-center" onclick="delme('{{$section->id}}')">
                    <i class="bi-trash3 text-slate-200"></i>
                    <span class="hidden md:flex ml-2">Remove section</span>
                </button>
            </form>
            @endrole

        </div>
    </div>

    <!-- registered students -->
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-80">Name / Father</th>
                    <th class="w-48">Roll No</th>
                    <th class="w-48">Reg No</th>
                    <th class="w-32">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $sr=$students->count();@endphp
                @foreach($students->sortBy('rollno') as $student)
                <tr class="tr">
                    <td>
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($student->gender=='M')
                                <i class="bx bx-male text-orange-400 text-lg"></i>
                                @else
                                <i class="bx bx-female text-indigo-400 text-lg"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-800">{{$student->name}}</div>
                                <div class="text-slate-400 text-sm">{{$student->father}}
                                </div>
                            </div>

                        </div>

                    </td>
                    <td class="text-center">{{$student->rollno}}</td>
                    <td class="text-center">{{$student->regno}}</td>
                    <td>
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{route('students.edit', $student)}}">
                                <i class="bi-pencil-square"></i>
                            </a>
                            @role('super')
                            <form action="{{route('students.destroy',$student)}}" method="POST" id='del_form{{$student->id}}' class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$student->id}}')">
                                    <i class="bi-trash3"></i>
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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection