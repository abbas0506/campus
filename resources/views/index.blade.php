@extends('layouts.basic')

@section('body')
<div class="flex flex-col items-center justify-center h-screen bg-gray-600 px-5">

    <div class="flex flex-col items-center w-full p-8 md:w-1/3 bg-white relative">

        @guest
        <img class="md:w-3/4 mt-8" alt="logo" src="{{asset('/images/logo/logo.png')}}">
        <h1 class="text-2xl md:text-4xl font-thin text-indigo-900 font-culpa tracking-wider">Exam Portal</h1>

        <div class="w-full mt-4">

            @if ($errors->any())
            <div class="alert-danger text-sm w-full mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- <h3 class="text-xs">Not a user? Please, contact system admin!</h3> -->
            <form action="{{url('login')}}" method="post" class="w-full mt-1">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="flex items-center w-full relative">
                        <i class="bi bi-envelope-at absolute left-2 text-slate-600"></i>
                        <input type="text" id="email" name="email" class="w-full custom-input px-8 py-1" placeholder="Type your email here">
                    </div>
                    <div class="flex items-center w-full mt-3 relative">
                        <i class="bi bi-key absolute left-2 text-slate-600 -rotate-[45deg]"></i>
                        <input type="password" id="password" name="password" class="w-full custom-input px-8 py-1" placeholder="Password">
                        <!-- eye -->
                        <i class="bi bi-eye-slash absolute right-5 eye-slash" onclick="showpw()"></i>
                        <i class="bi bi-eye absolute right-5 eye hidden" onclick="hidepw()"></i>
                    </div>
                    <div class="flex justify-end w-full mt-1">
                        <a href="{{route('passwords.forgot')}}" class="link text-slate-700 float-right text-xs">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full mt-4 btn-indigo p-2">Login</button>

                </div>
            </form>
        </div>
        @else
        <!-- authenticated -->
        <i class="bi bi-person-fill-check text-8xl text-sky-600"></i>
        <a href="{{url('signout')}}" class="absolute top-1 right-2"><i class="bi-x text-black"></i></a>
        <h1 class="text-slate-800 mt-8 text-xl">Welcome back {{Auth::user()->name}}!</h1>

        <form action="{{route('login.as')}}" method='post' class="w-full mt-2" onsubmit="return validate(event)">
            @csrf
            <select id="role" name="role" class="custom-input px-4 w-full py-0 mt-3 bg-transparent" onchange="loadDepartments()">
                <option value="" class="py-0">Please select a role</option>
                @foreach(Auth::user()->roles as $role)
                <option value="{{$role->name}}" class="py-0">{{ucfirst($role->name)}}</option>
                @endforeach
            </select>
            <div id='deptt_container' class="hidden">
                <div class="mt-6">
                    <select id="department_id" name="department_id" class="custom-input px-4 py-3 w-full">

                    </select>
                </div>
            </div>
            <div class="flex items-center space-x-4 mt-3">
                <!-- <a href="{{url('signout')}}" class="flex flex-1 btn-orange justify-center py-2">Singout</a> -->
                <button type="submit" class="flex flex-1 btn-indigo justify-center py-2">Proceed </button>
            </div>

        </form>

        @endguest
    </div>

</div>
@endsection
@section('script')
<script>
    function showpw() {
        $('#password').prop({
            type: "text"
        });
        $('.eye-slash').hide()
        $('.eye').show();
    }

    function hidepw() {
        $('#password').prop({
            type: "password"
        });
        $('.eye-slash').show()
        $('.eye').hide();
    }

    function loadDepartments() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var role = $('#role').val();
        if (role == 'super' || role == 'hod' || role == 'internal' || role == 'coordinator') {
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
        } else {
            $('#deptt_container').slideUp()
        }
    }

    function validate(event) {
        var validated = true;
        var role = $('#role').val()
        var department = $('#department_id').val()

        if (role == '') {
            validated = false;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Please select a role',
                showConfirmButton: false,
                timer: 1500,
            })

        }
        return validated;
    }
</script>

@endsection