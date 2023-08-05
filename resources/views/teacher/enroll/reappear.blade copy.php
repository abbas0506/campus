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
        <!-- search for student record, if exists ....display it it -->
        <div class="flex justify-center items-center w-full h-full">
            <div class="flex flex-col w-full">
                <label for="">Roll No.</label>
                <input type="text" id='rollno' class="flex-1 input-indigo py-1 px-4" placeholder="Enter student's roll no.">
                <button type='button' class="btn-teal mt-3" onclick="searchReappearer()">Fetch Record</button>
            </div>
        </div>
    </div>
    <div class="border p-5 relative ">
        <div class="absolute top-0 left-0 bg-orange-100 text-xs px-2">Step 2</div>
        <!-- display query output -->
        <div class="flex flex-col items-center">
            <i class="bx bx-user bx-sm mt-3"></i>
            <div class="text-sm font-semibold mt-3" id='student_info'></div>

            <table class="table-auto w-full mt-3">
                <thead>
                    <tr class="border-b border-slate-200 w-full">
                        <th class="text-sm font-medium">Semester</th>
                        <th class="text-sm font-medium">No.</th>
                        <th class="text-sm font-medium">Marks</th>
                        <th class="text-sm font-medium">GP</th>
                        <th class="text-sm font-medium">Grade</th>
                    </tr>
                </thead>
                <tbody id='tbody'>
                </tbody>
            </table>

            <!-- on submit, allow student to reappear in current semester  -->
            <form id='action_form' action="{{route('reappears.store')}}" method="post" class="flex flex-col justify-center items-center w-full hidden" onsubmit="return validate(event)">
                @csrf
                <div class="flex justify-end">
                    <input type="text" id='course_allocation_id' name='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">

                    <input type="text" name="rollno" class="hidden">
                    <button type='submit' class="btn-red rounded mt-4">Enroll Now</button>
                </div>
            </form>

        </div>

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
                    $('#student_info').html(response.student_info)
                    $('#tbody').html(response.result)

                    if (response.eligible == 1) {
                        $('#action_form').slideDown()
                        $("[name='rollno']").val(rollno)
                    } else
                        $('#action_form').slideUp()

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