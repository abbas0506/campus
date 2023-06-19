@extends('layouts.teacher')
@section('page-content')

<h1 class="mt-12 mb-5"><a href="{{route('mycourses.index')}}">My Courses </a><span class="font-thin text-slate-600 text-sm"> &#x23F5; Enroll Re-appear</span></h1>
<a href="{{route('mycourses.show',$course_allocation)}}" class="text-sm text-slate-800 hover:text-blue-800">
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

    @if(session('error'))
    <div class="flex alert-danger items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('error')}}
    </div>
    @endif

    <!-- search for reappearer, if exists ....save it -->
    <form action="{{route('reappears.store')}}" method="post" onsubmit="return validate(event)" class="mt-24">
        @csrf
        <div class="flex flex-col justify-center items-center mt-12">
            <div class="flex flex-col w-3/4">
                <input type="text" id='course_allocation_id' name='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">
                <label for="">Roll No.</label>
                <div class="flex items-center space-x-4">
                    <input type="text" id='rollno' name='rollno' class="flex-1 input-indigo py-1 px-4" placeholder="Enter Roll No.">
                    <button type='button' class="btn-teal p-2" onclick="searchReappearer()">Fetch Record</button>
                </div>
                <div id='search_output' class="flex items-center bg-green-100 relative mt-8 p-2">
                    <div class="w-12 h-12 absolute -left-2 rounded-full flex items-center justify-center bg-teal-500 text-yellow-400 ring-4 ring-slate-50">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="flex flex-col ml-12">
                        <div class="font-bold" id='student_info'></div>
                    </div>
                </div>
                <div class="ml-8 hidden" id='last_attempt'>
                    <div class="font-bold" id='student_info'></div>
                    <table class="table-auto w-full mt-8">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th>Semester</th>
                                <th>#</th>
                                <th>Marks</th>
                                <th>GP</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody id='tbody'>
                        </tbody>
                    </table>
                    <div class="flex justify-end">
                        <button type='submit' class="btn-red rounded mt-4">Enroll</button>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

<script type="text/javascript">
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
                    $('#search_output').show();
                    $('#student_info').html(response.student_info)
                    $('#tbody').html(response.result)

                    if (response.result == '')
                        $('#last_attempt').hide()
                    else
                        $('#last_attempt').show()

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

    function validate(event) {
        var validated = true;
        var last_attempt = $('#tbody').html()

        if ($.trim(last_attempt) == '') {
            event.preventDefault();
            validated = false;

            Swal.fire({
                icon: 'warning',
                title: 'Data missing!',
                showConfirmButton: false,
                timer: 1500,
            })

        }
        return validated;
        // return false;

    }
</script>

@endsection