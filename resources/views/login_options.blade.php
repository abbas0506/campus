@extends('layouts.basic')

@section('content')

<div class="container w-screen bg-cover bg-center" style="background-image: url({{asset('/images/bg/blue.jpg')}});">
    <div class="flex flex-col h-screen justify-center items-center mx-auto px-4 w-full md:w-1/2">

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="flex flex-col md:flex-row items-center p-8 w-full border border-gray-200">
            <div class="mr-8 text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <div>
                <h1>Welcome, {{Auth::user()->name}}!</h1>
                <ul class="list-disc text-slate-700 leading-relaxed">
                    <li>You have successfully logged into the system</li>
                    <li>Now let the system know, how would you like to proceed as?</li>
                </ul>
            </div>
        </div>


        <form action="{{route('login-options.store')}}" method='post' class="w-full mt-8" onsubmit="return validate(event)">
            @csrf

            <label for="" class="text-base text-left">I would like to proceed as</label>
            <select id="role" name="role" class="input-indigo  px-4 py-3 w-full mt-1 bg-transparent" onchange="loadDepartments()">
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

            <div class="flex space-x-4 mt-8 justify-center md:justify-end items-center">
                <a href="{{url('signout')}}" class="flex justify-center btn-gray py-2 px-8">Singout</a>
                <button type="submit" class="flex justify-center btn-sky py-2 px-8">Proceed</button>
            </div>

        </form>

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