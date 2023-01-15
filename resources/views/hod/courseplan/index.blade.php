@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Course Plan</h1>
<div class="bread-crumb">Course Plan / Choose section</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Scroll down to concerned class (or search by program)</li>
        <li>Click on any section to plan courses and assign teachers for current semester</li>
        <li></li>
    </ul>
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
@if(session('error'))
<div class="flex items-center alert-danger mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('error')}}
</div>
@endif

<!-- search bar -->
<div class="flex items-center justify-between mt-8">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
</div>
<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$programs->count()}} programs found</div>

<!-- Programs and classes -->
<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Programs</th>
            <th>Shift</th>
            <th>Classes</th>
            <th>Sections</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr class="tr{{$program->id}} tr">
            <td rowspan='{{$program->clases->count()+1}}' class="text-center">{{$program->name}}</td>
        </tr>
        @foreach($program->clases as $clas)
        <tr class="tr{{$program->id}}">
            <td class="text-center">{{$clas->shift->name}}</td>
            <td> {{$clas->subtitle()}}</td>
            <td>
                <div class="flex space-x-2">
                    @foreach($clas->sections as $section)
                    <a href="{{route('courseplan.show',$section)}}" class='px-1 bg-teal-100 hover:text-slate-50 hover:bg-teal-800 transition-all duration-400 ease-in-out'>
                        {{$section->name}}
                    </a>
                    @endforeach
                </div>
            </td>

        </tr>

        @endforeach
        @endforeach

    </tbody>
</table>

@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();

        var classesToShow = [];
        $('.tr').each(function() {
            if ($(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)) {
                var matched = $(this).attr('class').split(' ');
                classesToShow.push(matched[0]);
            }
        });
        var toShow = classesToShow;
        var rowid;
        $('tbody tr').each(function() {
            rowid = $(this).attr('class').split(' ')

            if ($.inArray(rowid[0], toShow) >= 0) {
                $(this).removeClass('hidden')

            } else
                $(this).addClass('hidden')
        });

    }
</script>

@endsection