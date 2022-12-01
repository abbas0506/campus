@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12">My Courses</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">My Courses </a> / {{$course_allocation->course->name}} / {{$course_allocation->section->title()}}
    </div>
</div>

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

    <div class="flex flex-col justify-center items-center mt-12">
        <form action="{{route('results.store')}}" class="flex flex-col w-3/4" method="post">
            @csrf
            <!-- <div class="text-2xl text-indigo-500">Search by roll # or </div> -->
            <input type="text" id='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">
            <label for="">Reappearing Student's Info</label>
            <input type="text" id='rollno' class="input-indigo py-2 px-4 mt-1" placeholder="Enter Roll No or Registration No">

            <input type="text" id='course_track_id' name='course_track_id' class="" value="">
            <input type="text" name='teacher_id' value="{{$course_allocation->teacher_id}}" hidden>
            <input type="text" name='semester_id' value="{{$course_allocation->semester_id}}" hidden>
            <input type="text" name='semester_no' value="{{$course_allocation->semester_no}}" hidden>

            <button type='button' class="btn-indigo p-2 mt-4" onclick="searchReappearer()">Search</button>


            <button type='submit' id='search_output' class="flex items-center bg-green-100 relative mt-8 ml-4 p-2">
                <div class="w-16 h-16 absolute -left-4 rounded-full flex items-center justify-center bg-teal-500 text-yellow-400 ring-4 ring-slate-50">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>

                </div>
                <div class="flex flex-col pl-12 ">
                    <div class="font-bold" id='student_info'></div>
                    <div class="text-sm text-gray-500">Please click on me</div>
                </div>
            </button>


        </form>
    </div>



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

    function showOrHide() {
        var choice = $('#choice').val();
        if (choice == 0) {
            $('#sxnEnrolled').removeClass('hidden')
            $('#sxnEnrollFresh').addClass('hidden')

            $('#btnStartFeeding').removeClass('hidden')
            $('#btnRegisterNow').addClass('hidden')

        } else if (choice == 1) {
            $('#sxnEnrolled').addClass('hidden')
            $('#sxnEnrollFresh').removeClass('hidden')

            $('#btnStartFeeding').addClass('hidden')
            $('#btnRegisterNow').removeClass('hidden')

        }

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

    function searchReappearer() {
        var token = $("meta[name='csrf-token']").attr("content");

        var course_allocation_id = $('#course_allocation_id').val();
        var rollno = $('#rollno').val();

        if (rollno == '') {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to search",
            });
        } else {
            //show sweet alert and confirm submission

            $.ajax({
                type: 'POST',
                url: "{{url('searchReappearer')}}",
                data: {
                    "course_allocation_id": course_allocation_id,
                    "rollno": rollno,
                    "_token": token,

                },
                success: function(response) {
                    //
                    // alert(response.student_id)
                    $('#search_output').show();
                    $('#course_track_id').val(response.course_track_id)
                    $('#student_info').html(response.student_info)
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: errorThrown
                    });
                }
            }); //ajax end


        }

    }

    function enrollReappererNow() {

        var token = $("meta[name='csrf-token']").attr("content");

        var course_allocation_id = $('#course_allocation_id').val();
        var rollno = $('#rollno').val();

        if (student_id == '') {
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