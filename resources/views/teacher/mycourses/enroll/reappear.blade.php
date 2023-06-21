@extends('layouts.teacher')
@section('page-content')

<div class="flex">
    <a href="{{route('mycourses.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>My Courses</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">Enroll Re-Appearing Students</div>
    <div class="text-sm">{{$course_allocation->course->name}}</div>
    <div class="text-sm">{{$course_allocation->section->title()}}</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 mt-16">
    <div class="p-5 border relative">
        <div class="absolute top-0 left-0 bg-orange-100 text-xs px-2">Step 1</div>
        <!-- search for reappearer, if exists ....save it -->
        <div class="flex justify-center items-center w-full h-full">
            <div class="flex flex-col w-full">
                <input type="text" id='course_allocation_id' name='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">
                <label for="">Roll No.</label>
                <input type="text" id='rollno' name='rollno' class="flex-1 input-indigo py-1 px-4" placeholder="Enter student's roll no.">
                <button type='button' class="btn-teal mt-3" onclick="searchReappearer()">Fetch Record</button>
                <!-- <a href="{{route('reappears.index')}}">Click</a> -->
            </div>
        </div>

        <!-- <div class="flex flex-col">

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
    </div> -->
        <!-- </form> -->

    </div>
    <div class="border p-5 relative">
        <div class="absolute top-0 left-0 bg-orange-100 text-xs px-2">Step 2</div>
        <!-- display query output -->
        <form action="{{route('reappears.store')}}" method="post" class="flex flex-col justify-center items-center w-full" onsubmit="return validate(event)">
            @csrf
            <i class="bx bx-user bx-md"></i>
            <div class="" id='last_attempt'>
                <div class="text-sm font-semibold" id='student_info'></div>
                <table class="table-auto w-full mt-8">
                    <thead>
                        <tr class="border-b border-slate-200 w-full">
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

        </form>
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

    @if(session('error'))
    <div class="flex alert-danger items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('error')}}
    </div>
    @endif


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
                    // alert(rollno)
                    //
                    // $('#search_output').show();
                    $('#student_info').html(response.student_info)
                    $('#tbody').html(response.result)

                    // if (response.result == '')
                    //     $('#last_attempt').hide()
                    // else
                    //     $('#last_attempt').show()

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