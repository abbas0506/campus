@extends('layouts.hod')
@section('page-content')

<h1>Schemes</h1>
<div class="bread-crumb">Programs / all</div>
<div class="flex items-center justify-between flex-wrap mt-8">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
</div>

@if(session('success'))
<div class="alert-success mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>

    {{session('success')}}
</div>
@endif
<div class="flex items-center mt-8 mb-1">
    <div class="text-sm  text-gray-500">{{$programs->count()}} records found <span class='text-xs text-slate-600 ml-4 bg-teal-100 px-2'>(S=Spring, F=Fall)</span></div>
    <div class="text-xs text-gray-500 ml-4"><i class="bx bxs-hand-right text-indigo-600 mr-2"></i>Click on + icon to add new scheme</div>
</div>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Program Name</th>
            <th>Scheme(s)</th>
        </tr>
    </thead>
    <tbody>

        @foreach($programs->sortBy('level') as $program)
        <tr class="tr">
            <td>{{$program->short}}</td>
            <td>
                <div class="flex items-center space-x-2">
                    @foreach($program->schemes as $scheme)
                    <a href="{{route('schemes.show', $scheme)}}" class="w-12 px-2 text-sm bg-teal-100 text-center hover:bg-teal-600 hover:text-white">
                        {{$scheme->subtitle()}}
                    </a>
                    @endforeach
                    <a href="{{route('schemes.append',$program)}}" class="flex items-center justify-center border border-dashed border-slate-200 bg-teal-50 hover:bg-teal-600 hover:text-white text-teal-800  w-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>

                    </a>
                </div>
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