@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mt-12 mb-5 md:my-10">
            <h1 class="text-indigo-500 text-xl">Students</h1>
            <a href="{{route('students.create')}}" class="bg-indigo-600 hover:bg-indigo-500 ml-5 p-2 rounded-full flex text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>
        <!-- serach field -->
        <div class="relative ml-0 md:ml-20">
            <input type="text" id="search_input" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <!-- filter by gender -->
        <div class="flex flex-row items-center md:w-1/4 ml-4">
            <label for="" class="py-2 text-sm text-gray-400 ml-4">Gender</label>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 icon-gray ml-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <select id="gender" name="" class="input-indigo p-1 ml-4" onchange="search(event)">
                <option value="">All</option>
                <option value="M">M</option>
                <option value="F">F</option>
                <option value="T">T</option>
            </select>
        </div>
    </div>

    <div class="text-xl text-slate-800">{{session('semester')->semester_type->name}} {{session('semester')->year}}</div>
    <div class="text-sm text-slate-500">{{session('program')->short}},
        @if(session('shift_id')=='M') Morning
        @elseif(session('shift_id')=='E') Evening
        @endif
        ({{session('section')->name}})
    </div>

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
                <th class="p-2 text-gray-600 text-left">Sr</th>
                <th>Student</th>
                <th>Address</th>
                <th class='text-center'>Actions</th>
            </tr>
        </thead>
        <tbody>

            @php $sr=$students->count();@endphp
            @foreach($students->sortByDesc('id') as $student)
            <tr class="tr border-b ">
                <td class="p-2">#{{$sr--}}</td>
                <td class="py-2">
                    <div>{{$student->user->name}}</div>
                    <div class="text-sm text-gray-500">{{$student->user->email}}</div>
                    <div class="text-sm text-gray-500">{{$student->cnic}}</div>
                </td>
                <td hidden>{{$student->gender}}</td>
                <td class="py-2">
                    <div>
                        @if($student->domicile){{$student->domicile->name}}@endif
                        @if($student->province), {{$student->province->name}}@endif
                        @if($student->nationality), {{$student->nationality->name}}@endif </div>
                    <div class="text-sm text-gray-500">{{$student->address}}</div>
                </td>

                <td class="py-2 flex items-center justify-center">
                    <a href="{{route('students.edit', $student)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </a>
                    <form action="{{route('students.destroy',$student)}}" method="POST" id='del_form{{$student->id}}' class="mt-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$student->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
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
        var searchtext = $('#search_input').val().toLowerCase();
        var filter = $('#gender').val().toLowerCase();

        if (filter === '') {
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        } else if (searchtext === '') {
            $('.tr').each(function() {
                if (!(
                        ($(this).children().eq(2).prop('outerText').toLowerCase() === filter)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        } else {

            $('.tr').each(function() {
                if (!($(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) &&
                        ($(this).children().eq(2).prop('outerText').toLowerCase() === filter)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

    }
</script>

@endsection