@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Classes</h1>
<div class="bread-crumb">Classes & Sections / all</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Class will be deleted only if it has no section (i.e. empty class)</li>
        <li>Section delete option is not available on this page. It is available on section page itself. (click on section)</li>
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
    <div class="flex items-center space-x-3">
        <a href="{{route('promotions.index')}}" class="flex items-center text-sm btn-teal px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
            <span class="ml-1">Promote</span>
        </a>
        <a href="{{route('reversions.index')}}" class="flex items-center text-sm btn-red px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>
            <span class="ml-1">Revert</span>
        </a>
    </div>

</div>
<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-4 mb-1">{{$programs->count()}} programs found</div>

@php $selected_shift=(session()->has('shift_id')? session('shift_id'):1); @endphp

<!-- morning classes -->
<section id='morning' @if($selected_shift==2) hidden @endif>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th rowspan="2">Programs</th>
                <th colspan="2">
                    <div class="">
                        <div>Morning <span class="text-xs font-thin">(Classes & Sections)</span></div>
                        <button class="relative text-blue-500 hover:underline font-thin" onclick="switchTo('self')">
                            <div class="absolute flex items-center justify-center h-3 w-3 top-1 -left-4 rounded-full">
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-400"></span>
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-600 opacity-75"></span>
                            </div>
                            Switch to Self Suport
                        </button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>Classes</th>
                <th>Sections</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $program)
            <tr class="tr{{$program->id}} tr">
                <td rowspan='{{$program->morning_clases->count()+2}}'>{{$program->name}}</td>
            </tr>
            @foreach($program->morning_clases as $clas)
            <tr class="tr{{$program->id}}">
                <td>
                    <div class="flex items-center justify-between">
                        <div class="flex-1">{{$clas->subtitle()}}</div>
                        <div class="text-xs text-right text-slate-400">({{$clas->strength()}})</div>
                        <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->strength()>0)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
                <td>
                    <div class="grid grid-cols-4 md:grid-col-6  gap-2">
                        @foreach($clas->sections as $section)
                        <a href="{{route('sections.show',$section)}}" class='flex justify-center items-center bg-teal-100 hover:bg-teal-600 hover:text-slate-100'>
                            {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                        </a>
                        @endforeach
                        <form action="{{route('sections.store')}}" method="post" class='flex justify-center items-center border-dashed text-teal-800 hover:bg-teal-100'>
                            @csrf
                            <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                            <button type='submit'>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>

            </tr>

            @endforeach

            <!-- add new morning class for current program  -->
            <tr class="tr{{$program->id}}">
                <td>
                    @if($program->schemes->count()>0)
                    <a href="{{route('clases.append',[$program,1])}}" class="flex items-center text-blue-300 hover:text-blue-600 hover:underline text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        Add Class
                    </a>
                    @else
                    <a href="{{route('schemes.append',$program)}}" class="flex items-center text-blue-300 hover:text-blue-600 hover:underline text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        Define Scheme
                    </a>
                    @endif
                </td>
                <td></td>
            </tr>
            @endforeach

        </tbody>
    </table>
</section>

<!-- self support section -->
<section id='selfsupport' @if($selected_shift==1) hidden @endif>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th rowspan="2">Porgram</th>
                <th colspan="2">
                    <div>
                        <div>Self Support <span class="text-xs font-thin">(Classes & Sections)</span></div>
                        <button class="relative text-blue-500 hover:underline font-thin" onclick="switchTo('morning')">
                            <div class="absolute flex items-center justify-center h-3 w-3 top-1 -left-4 rounded-full">
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-400"></span>
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-600 opacity-75"></span>
                            </div> Switch to Morning
                        </button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>Classes</th>
                <th>Sections</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $program)
            <tr class="tr{{$program->id}} tr">
                <td rowspan='{{$program->selfsupport_clases->count()+2}}'>{{$program->name}}</td>
            </tr>
            @foreach($program->selfsupport_clases as $clas)
            <tr class="tr{{$program->id}}">
                <td>
                    <div class="flex items-center justify-between">
                        {{$clas->subtitle()}}
                        <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->sections->count()>0)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
                <td>
                    <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach($clas->sections as $section)
                        <a href="{{route('sections.show',$section)}}" class='flex justify-center items-center bg-teal-100 hover:bg-teal-600 hover:text-slate-100'>
                            {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                        </a>
                        @endforeach
                        <!-- append section -->
                        <form action="{{route('sections.store')}}" method="post" class='flex justify-center items-center border-dashed text-teal-800 hover:bg-teal-100'>
                            @csrf
                            <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                            <button type='submit'>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>

            </tr>

            @endforeach

            <!-- add new self support class for current program  -->
            <tr class="tr{{$program->id}}">
                <td>

                    @if($program->schemes->count()>0)
                    <a href="{{route('clases.append',[$program,2])}}" class="flex items-center text-blue-600 hover:text-blue-800 hover:underline text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        Add Class
                    </a>
                    @else
                    <a href="{{route('schemes.append',$program)}}" class="flex items-center text-blue-600 hover:text-blue-600 hover:underline text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        Define Scheme
                    </a>
                    @endif
                </td>
                <td></td>
            </tr>
            @endforeach

        </tbody>
    </table>
</section>
@endsection
@section('script')
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

    function switchTo(opt) {
        if (opt == 'morning') {
            $('#morning').show()
            $('#selfsupport').hide()

        } else {
            $('#morning').hide()
            $('#selfsupport').show()
        }
    }
</script>

@endsection