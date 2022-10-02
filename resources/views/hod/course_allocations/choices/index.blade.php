@extends('layouts.hod')
@section('page-content')
<div class="container px-12">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mt-12 mb-5 md:my-10">
            <h1 class="text-indigo-500 text-xl">Course Allocation | Programs</h1>
        </div>
        <!-- serach field -->
        <div class="relative ml-0 md:ml-20">
            <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>
    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif

    <table class="table-auto w-full">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="py-2 text-gray-600 text-left">Program Name</th>
                <th class="py-2 text-gray-600 text-left">Duration</th>
                <th class="py-2 text-gray-600 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($programs->sortByDesc('id') as $program)
            <tr class="tr border-b ">
                <td class="py-2">
                    <div>{{$program->name}}</div>
                    <div class="text-sm text-gray-500">{{$program->short}}</div>
                    <div class="text-sm text-gray-500">{{$program->code}}</div>

                </td>
                <td class="py-2">
                    <div class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-1 text-sm">{{$program->duration}} years</span>
                    </div>

                </td>

                <td class="py-2 text-center">
                    <a href="{{route('course-allocation-choices.show',$program)}}" class="bg-green-300 hover:bg-green-400 rounded-full px-2 text-xs text-gray-900">Select</a>
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