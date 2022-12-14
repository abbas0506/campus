@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12"><a href="{{route('mycourses.index')}}">My Courses</a></h1>
<div class="bread-crumb">Enroll fresh students</div>
<a href="{{route('mycourses.show',$course_allocation)}}" class="flex flex-col text-sm border text-slate-800 py-3 mt-8 px-3 hover:bg-slate-100">
    <div class="font-bold">{{$course_allocation->course->name}}</div>
    <div>{{$course_allocation->section->title()}}</div>
</a>
<div class="container w-full mx-auto mt-8">

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

    <input type="text" id='course_allocation_id' value='{{$course_allocation->id}}' hidden>
    <div class="flex items-center justify-between py-2 space-x-5 mt-12">
        <div class="flex flex-growtab items-center">
            <div class="tab active">
                Fresh Students
                <div class="bullet"></div>
            </div>
            <a href="{{route('enroll.ra', $course_allocation)}}" class="tab">Reappearing</a>
        </div>
        <button class="px-4 py-2 bg-teal-600 text-slate-100 rounded-sm hover:bg-teal-500" id='btnRegisterNow' onclick="enrollFirstAttempt()">
            Enroll Selected <span class="ml-2">(</span><span id='chkCount' class="">0</span>/{{$unregistered->count()}})
        </button>
    </div>
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
</div>

<script type="text/javascript">
    //fresh enrollment
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
                        url: "{{route('first_attempts.store')}}",
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