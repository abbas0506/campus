@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Classes</h1>
<div class="bread-crumb">Classes / all</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Class will be deleted only if it has no section (i.e. empty class)</li>
        <li>Section delete option is not available on this page. It is available on section page itself. (click on section)</li>
    </ul>
</div>

<!-- search bar -->
<div class="flex items-center justify-between mt-8">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
    <button class="flex items-center text-sm btn-indigo" onclick="promote()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
        </svg>

        <span class="ml-2">Promote / Revert Classes</span>
    </button>

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


<div class="text-sm  text-gray-500 mt-8 mb-1">{{$programs->count()}} programs found</div>
<table class="table-fixed w-full">
    <thead>
        <tr>
            <th rowspan="2">Porgram</th>
            <th colspan="2">Morning <span class="text-xs font-thin">(Classes & Sections)</span></th>
            <th colspan="2">Self Support <span class="text-xs font-thin">(Classes & Sections)</span></th>
        </tr>
        <tr>
            <th>Classes</th>
            <th>Sections</th>
            <th>Classes</th>
            <th>Sections</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr>
            <td rowspan=2>{{$program->name}}</td>
            <td colspan=2 class="p-0 m-0">
                <table class="table-fixed w-full border-none">
                    <tbody>
                        @foreach($program->morning_clases as $clas)
                        <tr class="odd:bg-orange-50">
                            <td colspan="5">{{$clas->subtitle()}}</td>
                            <td>
                                <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}' class="flex items-center justify-center border-r pr-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->sections->count()>0)>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            <td colspan="6">
                                <div class="flex flex-1 flex-wrap items-center p-2 space-x-1">
                                    @foreach($clas->sections as $section)
                                    <a href="{{route('sections.show',$section)}}" class='flex items-center px-1 rounded border hover:bg-indigo-500 hover:text-slate-200'>{{$section->name}} <span class="ml-1 text-slate-400 text-xs">({{$section->students->count()}})</span></a>
                                    @endforeach
                                    <form action="{{route('sections.store')}}" method="post">
                                        @csrf
                                        <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                                        <button type='submit' class="flex items-center text-indigo-500 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <!-- <td>Sections</td> -->
            <td colspan=2 class="p-0 m-0">
                <table class="table-fixed w-full border-none">
                    <tbody>
                        @foreach($program->selfsupport_clases as $clas)
                        <tr class="odd:bg-orange-50">
                            <td colspan="5">{{$clas->subtitle()}}</td>
                            <td>
                                <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}' class="flex items-center justify-center border-r pr-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->sections->count()>0)>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            <td colspan="6">
                                <div class="flex flex-1 flex-wrap items-center p-2 space-x-1">
                                    @foreach($clas->sections as $section)
                                    <a href="{{route('sections.show',$section)}}" class='flex items-center px-1 rounded border hover:bg-indigo-500 hover:text-slate-200'>{{$section->name}} <span class="ml-1 text-slate-400 text-xs">({{$section->students->count()}})</span></a>
                                    @endforeach
                                    <form action="{{route('sections.store')}}" method="post">
                                        @csrf
                                        <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                                        <button type='submit' class="flex items-center text-indigo-500 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

        </tr>
        <tr>
            <!-- add new morning class for current program  -->
            <td colspan=2>
                <div class="flex items-center justify-center p-2">
                    <a href="{{route('clases.append',[$program->id,1])}}" class="btn-teal text-xs">
                        New class
                    </a>
                </div>
            </td>
            <!-- add new morning class for current program  -->
            <td colspan=2>
                <div class="flex items-center justify-center p-2">
                    <a href="{{route('clases.append',[$program->id,1])}}" class="btn-teal text-xs">
                        New class
                    </a>
                </div>
            </td>
        </tr>

        @endforeach

        @foreach($programs as $program)
        <tr class="tr">
            <td rowspan=2>{{$program->name}}</td>
            <td class="text-sm">
                @foreach($program->morning_clases as $clas)
                <div class="flex">
                    <div class="flex flex-1 items-center justify-between p-2">
                        <div class="flex items-center">{{$clas->subtitle()}}</div>
                        <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->sections->count()>0)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </td>
            <td>
                <!-- <div class="grid grid-cols-4 gap-2 p-2 border-l"> -->
                <div class="flex flex-1 flex-wrap items-center p-2 space-x-1">
                    @foreach($clas->sections as $section)
                    <a href="{{route('sections.show',$section)}}" class='flex items-center px-1 rounded border hover:bg-indigo-500 hover:text-slate-200'>{{$section->name}} <span class="ml-1 text-slate-400 text-xs">({{$section->students->count()}})</span></a>
                    @endforeach
                    <form action="{{route('sections.store')}}" method="post">
                        @csrf
                        <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                        <button type='submit' class="flex items-center text-indigo-500 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </button>
                    </form>
                </div>

                @endforeach

            </td>
            <td class="text-sm">
                @foreach($program->selfsupport_clases as $clas)
                <div class="flex border-b">
                    <div class="flex flex-1 items-center justify-between p-2">
                        <div class="flex items-center">{{$clas->subtitle()}}</div>
                        <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800 p-2" onclick="delme('{{$clas->id}}')" @disabled($clas->sections->count()>0)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <!-- <div class="grid grid-cols-4 gap-2 p-2 border-l"> -->
                    <div class="flex flex-1 flex-wrap items-center p-2 space-x-1 border-l">
                        @foreach($clas->sections as $section)
                        <a href="{{route('sections.show',$section)}}" class='flex items-center px-1 rounded border hover:bg-indigo-500 hover:text-slate-200'>{{$section->name}} <span class="ml-1 text-slate-400 text-xs">({{$section->students->count()}})</span></a>
                        @endforeach
                        <form action="{{route('sections.store')}}" method="post">
                            @csrf
                            <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                            <button type='submit' class="flex items-center text-indigo-500 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- add new morning class for current program  -->
            <td colspan=2>
                <div class="flex items-center justify-center p-2">
                    <a href="{{route('clases.append',[$program->id,1])}}" class="btn-teal text-xs">
                        New class
                    </a>
                </div>
            </td>
            <!-- add new morning class for current program  -->
            <td colspan=2>
                <div class="flex items-center justify-center p-2">
                    <a href="{{route('clases.append',[$program->id,1])}}" class="btn-teal text-xs">
                        New class
                    </a>
                </div>
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

    function chkAll() {
        $('.tr').each(function() {
            if (!$(this).hasClass('hidden'))
                $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));

        });
        updateChkCount()
    }

    function updateChkCount() {

        var chkArray = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) chkArray.push(chk.value);
        })
        document.getElementById("chkCount").innerHTML = chkArray.length;
    }

    function promote() {

        var token = $("meta[name='csrf-token']").attr("content");
        var ids_array = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) ids_array.push(chk.value);
        })

        if (ids_array.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to promote",
            });
        } else {
            //show sweet alert and confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected classes will be promoted to next semester!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, promote now'
            }).then((result) => { //if confirmed    
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('clases.promote')}}",
                        data: {
                            "ids_array": ids_array,
                            "_token": token,

                        },
                        success: function(response) {
                            //
                            Swal.fire({
                                icon: 'success',
                                title: response.msg,
                            });
                            //refresh content after deletion
                            location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'warning',
                                title: errorThrown
                            });
                        }
                    }); //ajax end
                }
            })
        }
    }


    function demote() {

        var token = $("meta[name='csrf-token']").attr("content");
        var ids_array = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) ids_array.push(chk.value);
        })

        if (ids_array.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to demote",
            });
        } else {
            //show sweet alert and confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected classes will be demoted to previous semester!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, demote now'
            }).then((result) => { //if confirmed    
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('clases.demote')}}",
                        data: {
                            "ids_array": ids_array,
                            "_token": token,

                        },
                        success: function(response) {
                            //

                            Swal.fire({
                                icon: 'success',
                                title: response.msg,
                            });
                            //refresh content after deletion
                            location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'warning',
                                title: errorThrown
                            });
                        }
                    }); //ajax end
                }
            })
        }
    }
</script>

@endsection