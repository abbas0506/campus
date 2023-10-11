@extends('layouts.hod')
@section('page-content')
<div class="flex">
    <a href="{{route('mycourses.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>My Courses</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">Enroll Fresh Students</div>
    <div class="text-sm">{{$course_allocation->course->name}}</div>
    <div class="text-sm">{{$course_allocation->section->title()}}</div>
</div>

<div class="container w-full mx-auto mt-12">

    @if ($errors->any())
    <div class="alert-danger mt-8 md:mx-24">
        <div class="w-10">
            <i class="bi-emoji-frown text-[24px]"></i>
        </div>
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    @if(session('success'))
    <div class="alert-success mb-8">
        <i class="bi-emoji-smile text-[24px] mr-4"></i>
        {{ session('success') }}
    </div>
    @endif

    <input type="text" id='course_allocation_id' value='{{$course_allocation->id}}' hidden>

    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <button class="btn-teal" id='btnRegisterNow' onclick="enrollFirstAttempt()">
            Enroll Fresh <span class="ml-2">(</span><span id='chkCount' class="">0</span>/{{$unregistered->count()}})
        </button>
    </div>

    <table class="table-auto w-full mt-4">
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
                <td class="py-2 text-slate-600 text-sm">
                    <div class="flex items-center justify-center">
                        <input type="checkbox" name='chk' value='{{$student->id}}' onclick="updateChkCount()">
                    </div>
                </td>
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
</div>

<script type="text/javascript">
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

    function enrollFirstAttempt() {

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
                        url: "{{route('hod.first-attempts.store')}}",
                        data: {
                            "course_allocation_id": course_allocation_id,
                            "ids_array": ids_array,
                            "_token": token,

                        },
                        success: function(response) {
                            //

                            alert(response.msg)
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: response.msg,
                            // });
                            // //refresh content after deletion
                            // location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(response.mg)
                            // Swal.fire({
                            //     icon: 'warning',
                            //     title: errorThrown
                            // });
                        }
                    }); //ajax end
                }
            })
        }
    }
</script>

@endsection