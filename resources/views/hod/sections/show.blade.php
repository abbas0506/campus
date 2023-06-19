@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('clases')}}">Classes / Sections</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$section->title()}}
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

    <div class="flex items-center justify-between font-thin text-slate-600 mt-8 mb-4">
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

        <div class="flex items-center space-x-4">
            <a href="{{route('students.add', $section)}}" class="btn-indigo flex items-center">
                <i class="bx bx-user-plus mr-2"></i>
                <span class="text-sm">Manual Feed</span>

            </a>
            <a href="{{route('students.excel', $section)}}" class="btn-teal flex items-center">
                <i class="bx bx-upload mr-2"></i>
                <span class="text-sm">From Excel</span>

            </a>

            <form action="{{route('sections.destroy',$section)}}" method="POST" id='del_form{{$section->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-red flex items-center justify-center" onclick="delme('{{$section->id}}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <span class="text-sm">Remove section</span>
                </button>
            </form>

        </div>


    </div>

    <!-- registered students -->
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Name / Father</th>
                <th>Roll No</th>
                <th>Reg No</th>
                <th>Actions</th>
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
                            <i class="bx bx-male text-blue-600 text-lg"></i>
                            @else
                            <i class="bx bx-female text-teal-600 text-lg"></i>
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
                    <div class="py-2 flex items-center justify-center space-x-4">
                        <a href="{{route('students.edit', $student)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                        <form action="{{route('students.destroy',$student)}}" method="POST" id='del_form{{$student->id}}' class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$student->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- not registered -->

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