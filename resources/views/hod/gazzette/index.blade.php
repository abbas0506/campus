@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Gazzette</h1>

<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Classes / all
    </div>

</div>
<div class="relative w-60 mt-12">
    <input type="text" placeholder="Search here" class="search-indigo w-full" oninput="search(event)">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
    </svg>
</div>
@if(session('success'))
<div class="flex alert-success items-center mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('success')}}
</div>
@endif
@if(session('error'))
<div class="alert-danger mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('error')}}
</div>
@endif

<table class="table-auto w-full mt-8">
    <thead>
        <tr class="border-b border-slate-200">
            <th>Class</th>
            <th>Sections</th>
        </tr>
    </thead>
    <tbody>

        @foreach($clases as $clas)
        <tr class="tr border-b">
            <td class="py-2 text-slate-600 text-sm">
                <div>{{$clas->title()}}</div>
            </td>

            <td class="flex items-center text-sm py-2">
                @foreach($clas->sections as $section)
                <a href="{{route('gazzette.show',$section)}}" class='px-1 rounded hover:bg-indigo-500 hover:text-slate-200'>{{$section->name}}</a>
                @endforeach

            </td>



        </tr>

        @endforeach


    </tbody>
</table>

<script type="text/javascript">
    function delme(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "It will be highly destructive!",
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