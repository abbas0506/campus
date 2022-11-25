@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-5">Course Registration</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">My Courses </a> / {{$course_allocation->course->name}} / students
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
        <div class="flex items-center space-x-4">
            <button class="btn-indigo font-thin hidden" onclick="toggleUnregistered()" id='btnToggleRegistered'>
                Show Registered
            </button>
            <button class="btn-indigo font-thin" onclick="toggleUnregistered()" id='btnToggleUnregistered'>
                Show Unregistered
            </button>
            <a href="{{route('students.create')}}" class="btn-indigo flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4  text-orange-200 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
                Re-appear
            </a>
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

    <input type="text" id='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">

    <!-- registered students -->
    <section id='registered' class="mt-16">
        @if($registered->count()>0)
        <div class="flex">
            <a href="{{route('results.edit', $course_allocation)}}" class="px-5 py-2 bg-teal-600 text-slate-100">
                Start Feeding Result <span class="ml-2">(</span><span class="mx-1">{{$registered->count()}}</span>)
            </a>
        </div>
        @endif
        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registered as $student)
                <tr class="tr border-b ">
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($student->gender=='M')
                                <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                @else
                                <div class="bg-green-500 w-2 h-2 rounded-full"></div>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-600">{{$student->name}}</div>
                                <div class="text-slate-600 text-sm">
                                    {{$student->rollno}}
                                    @if($student->regno)
                                    | {{$student->regno}}
                                    @endif
                                </div>
                            </div>

                        </div>

                    </td>
                    <td hidden>{{$student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$student->father}}
                    </td>
                    <td class="py-2 flex items-center justify-center">
                        <form action="{{route('registrations.destroy',$result)}}" method="POST" id='del_form{{$student->id}}' class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="delme('{{$student->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <!-- not registered students -->
    <section id='unregistered' class='hidden'>

        <button class="flex px-5 py-2 bg-teal-600 text-slate-100 mt-16" onclick="registerNow()">
            Register Now <span class="ml-2">(</span><span id='chkCount' class="mx-1">0</span> out of {{$unregistered->count()}})
        </button>

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th><input type="checkbox" id='chkAll' onclick="chkAll()"></th>
                    <th>Name</th>
                    <th>Father</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unregistered as $student)
                <tr class="tr border-b ">
                    <td class="py-2 text-slate-600 text-sm"><input type="checkbox" name='chk' value='{{$student->id}}' onclick="updateChkCount()"></td>
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($student->gender=='M')
                                <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                @else
                                <div class="bg-green-500 w-2 h-2 rounded-full"></div>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-600">{{$student->name}}</div>
                                <div class="text-slate-600 text-sm">
                                    {{$student->rollno}}
                                    @if($student->regno)
                                    | {{$student->regno}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$student->father}}
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

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

    function toggleUnregistered() {
        $('#registered').toggleClass('hidden');
        $('#unregistered').toggleClass('hidden');
        $('#btnToggleRegistered').toggleClass('hidden');
        $('#btnToggleUnregistered').toggleClass('hidden');

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

    function registerNow() {

        var token = $("meta[name='csrf-token']").attr("content");

        var course_allocation_id = $('#course_allocation_id').val();
        var ids_array = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) ids_array.push(chk.value);
        })

        if (ids_array.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to save",
            });
        } else {
            //show sweet alert and confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected students will be registered!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, register now'
            }).then((result) => { //if confirmed    
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('coursetracks.store')}}",
                        data: {
                            "course_allocation_id": course_allocation_id,
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