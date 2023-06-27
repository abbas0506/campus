@extends('layouts.basic')

@section('content')

<div class="flex flex-col items-center justify-center h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="flex flex-col items-center w-full px-5 md:w-1/3">
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-20 h-20 text-indigo-900">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg> -->
        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg> -->

        <i class="bi bi-person-fill-check text-8xl text-sky-600"></i>
        <!-- <h1 class="text-4xl mt-8 text-indigo-900 text-center font-culpa tracking-wider">Welcome</h1> -->
        <h1 class="text-center text-slate-800 mt-8">Welcome {{Auth::user()->name}}</h1>

        <form action="{{route('login-options.store')}}" method='post' class="w-full mt-8" onsubmit="return validate(event)">
            @csrf


            @if(Auth::user()->roles->count()>1)
            <div class="text-sm">You have multiple roles: [
                @foreach(Auth::user()->roles as $role)
                {{$role->name}},
                @endforeach
                ]
            </div>
            <div>Please select a role for this session</div>
            @else
            <label for="">You will proceed as</label>
            @endif

            <select id="role" name="role" class="input-indigo  px-4 py-3 w-full mt-3 bg-transparent" onchange="loadDepartments()">
                @if(Auth::user()->roles->count()>1)
                <option value="">- select -</option>
                @endif
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
                    <option value="{{$semester->id}}">{{$semester->short()}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-4 mt-4">
                <a href="{{url('signout')}}" class="flex flex-1 btn-orange justify-center py-1">Singout</a>
                <button type="submit" class="flex flex-1 btn-indigo justify-center py-1">Proceed <i class="bx bx-right-arrow-alt bx-fade-right text-lg"></i></button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('script')
<script lang="javascript">
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