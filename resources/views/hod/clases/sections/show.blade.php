@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>{{$section->title()}}</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.clases.index')}}">Current Classes</a>
        <div>/</div>
        <div>Students</div>
    </div>

    <!-- <h1 class='text-red-600 mt-8'>{{$section->title()}}</h1> -->
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
            <a href="{{route('hod.students.feed', $section)}}" class="btn-indigo flex items-center">
                <i class="bi bi-person-add"></i>
                <span class="hidden md:flex ml-2">Feed</span>
            </a>
            <a href="{{route('hod.students.excel', $section)}}" class="btn-teal flex items-center">
                <i class="bi-file-earmark-excel"></i>
                <span class="hidden md:flex ml-2">Import</span>
            </a>
            @if(Auth::user()->hasRole('super')||!$section->students()->exists())
            <form action="{{route('hod.sections.destroy',$section)}}" method="POST" id='del_section_form{{$section->id}}'>
                @csrf

                @method('DELETE')
                <button type="submit" class="btn-red flex items-center" onclick="del_section('{{$section->id}}')">
                    <i class="bi-trash3 text-slate-200"></i>
                    <span class="hidden md:flex ml-2">Delete</span>
                </button>
            </form>
            @endif

        </div>
    </div>

    <!-- registered students -->
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full text-sm">
            <thead>
                <tr>
                    <th class="w-8">Sr</th>
                    <th class="w-8"></th>
                    <th class="w-40">Roll No</th>
                    <th class="w-48">Student Name</th>
                    <th class="w-48">Father </th>
                    <th class="w-24">Status </th>
                    <th class="w-12"></th>
                </tr>
            </thead>
            <tbody>
                @php $sr=1;@endphp
                @foreach($section->students->sortBy('rollno') as $student)
                <tr class="tr">
                    <td>{{$sr++}}</td>
                    <td>

                        @if($student->gender=='M')
                        <i class="bx bx-male text-green-800 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif

                    </td>
                    <td><a href="{{route('hod.students.show',$student)}}" class="link">{{$student->rollno}}</a></td>
                    <td class="text-left">{{$student->name}}</td>
                    <td>{{$student->father}}</td>
                    <td>
                        @if($student->statuses()->exists())
                        <span class="text-red-600"> {{$student->statuses()->latest()->first()->status->name}}</span>
                        @else
                        <span class="text-green-800">active</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{route('hod.students.destroy',$student)}}" method="POST" id='del_student_form{{$student->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del_student('{{$student->id}}')">
                                <i class="bi bi-person-dash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

<script type="text/javascript">
    function del_section(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Section will be deleted permanantly!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_section_form' + formid).submit();
            }
        });
    }

    function del_student(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Student will be deleted permanantly!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_student_form' + formid).submit();
            }
        });
    }

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection