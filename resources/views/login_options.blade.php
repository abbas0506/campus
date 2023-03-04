@extends('layouts.basic')

@section('content')

<div class="flex flex-col md:flex-row h-screen w-full">

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col items-center justify-center flex-1 h-full bg-gradient-to-b from-teal-100 to-teal-50">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-32 h-32 text-teal-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg>
        <h1 class="text-3xl mt-8 text-teal-600">{{Auth::user()->name}}!</h1>
        <a href="{{url('signout')}}" class="flex justify-center bg-teal-200 hover:bg-teal-500 py-2 px-8 mt-8">Singout</a>
    </div>

    <div class="flex flex-1 justify-center items-center">
        <div class="w-full md:w-2/3 justify-center items-center p-8">

            <div class="flex items-center space-x-2 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
                <ul class="text-xs">
                    <li>Please choose your role for current session. However, you may switch to another role (if authorized) at any time.</li>
                </ul>
            </div>

            <form action="{{route('login-options.store')}}" method='post' class="w-full" onsubmit="return validate(event)">
                @csrf

                <label for="" class="text-base text-left">How would u like to proceed as?</label>
                <select id="role" name="role" class="input-indigo  px-4 py-3 w-full mt-3 bg-transparent" onchange="loadDepartments()">
                    <option value="" class="text-gray-600">Select a role</option>
                    @foreach(Auth::user()->roles as $role)
                    <option value="{{$role->name}}" class="">{{Str::upper($role->name)}}</option>
                    @endforeach
                </select>
                <div id='deptt_container' class="hidden">
                    <div class="mt-3">
                        <label for="" class="text-base text-gray-700 text-left">Department</label>
                        <select id="department_id" name="department_id" class="input-indigo px-4 py-3 w-full">

                        </select>
                    </div>
                </div>
                <div id='semester_container' class="mt-3 hidden">
                    <label for="" class="text-base text-gray-700 text-left w-full">Semester</label>
                    <select id="semester_id" name="semester_id" class="input-indigo px-4 py-3 w-full">
                        <option value="">Select a semester</option>
                        @foreach($semesters as $semester)
                        <option value="{{$semester->id}}">{{$semester->title()}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full mt-6 btn-teal p-2">Proceed</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script lang="javascript">
    function clearSelection() {

    }

    function loadDepartments() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var role = $('#role').val();
        if (role == 'hod') {
            //fetch concerned department by role
            $.ajax({
                type: 'POST',
                url: "fetchDepttByRole",
                data: {
                    "role": role,
                    "_token": token,
                },
                success: function(response) {
                    //
                    $('#department_id').html(response.options);
                    //scheme id will also be fetched dynamically
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: errorThrown
                    });
                }
            }); //ajax end

            $('#deptt_container').slideDown()
            $('#semester_container').slideDown()
        } else if (role == 'teacher') {
            $('#semester_container').slideDown();
            $('#deptt_container').slideUp()
        } else {
            $('#deptt_container').slideUp()
            $('#semester_container').slideUp()
        }

    }

    function validate(event) {
        var validated = true;
        var role = $('#role').val()
        var department = $('#department_id').val()
        var semester = $('#semester_id').val()

        if (role == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Please select a role',
                showConfirmButton: false,
                timer: 1500,
            })

        } else if (role == 'hod' || role == 'teacher') {
            //semester required for both
            if (semester == '') {
                validated = false;
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a semester',
                    showConfirmButton: false,
                    timer: 1500,
                })
            }
            //department required for only hod
            if (role == 'hod' && department == '') {
                validated = false;
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a department',
                    showConfirmButton: false,
                    timer: 1500,
                })
            }

            return validated;
            // return false;

        }
    }
</script>
@endsection