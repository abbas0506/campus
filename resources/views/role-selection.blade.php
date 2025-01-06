@extends('layouts.basic')

@section('body')
<style>
    .hero {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5),
            rgba(0, 0, 50, 0.5)),
        url("{{asset('/images/bg/uo.jpg')}}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-clip: border-box;
        position: relative;
    }
</style>
<div class="hero flex flex-col items-center justify-center h-screen px-5">
    <div class="flex flex-col justify-between items-center w-full px-8 py-4 md:w-1/3 bg-white relative opacity-80 rounded">

        <div>
            <i class="bi bi-person-fill-check text-8xl text-sky-600"></i>
        </div>

        <h2 class="mt-6">Welcome, {{ Auth::user()->name }}</h2>

        <ol class="flex items-center w-full mt-6">
            <li class="flex w-full items-center text-green-600 dark:text-green-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-teal-800">
                <span class="flex items-center justify-center w-10 h-10 bg-teal-200 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                    <i class="bi-check-lg"></i>
                </span>
            </li>
            <li class="flex w-full items-center text-green-600 dark:text-green-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-teal-800">
                <span class="flex items-center justify-center w-10 h-10 bg-teal-200 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                    <i class="bi-check-lg"></i>
                </span>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                    3
                </span>
            </li>
        </ol>


        <div class="border border-dashed p-4 w-full mt-8">
            <p class="text-sm text-slate-600">Please select a role for your current session and click on proceed button. </p>
        </div>
        <form action="{{route('login.as')}}" method='post' class="w-full mt-8" onsubmit="return validate(event)">
            @csrf
            <select id="role" name="role" class="custom-input px-4 w-full py-0 bg-transparent" onchange="loadDepartments()">
                <option value="" class="py-0">Please select a role</option>
                @foreach(Auth::user()->roles as $role)
                <option value="{{$role->name}}" class="py-0">{{ucfirst($role->name)}}</option>
                @endforeach
            </select>
            <div id='deptt_container' class="hidden">
                <div class="mt-3">
                    <select id="department_id" name="department_id" class="custom-input px-4 py-3 w-full">

                    </select>
                </div>
            </div>
            <div class="flex items-center space-x-4 mt-3">
                <!-- <a href="{{url('signout')}}" class="flex flex-1 btn-orange justify-center py-2">Singout</a> -->
                <button type="submit" class="flex flex-1 btn-indigo justify-center py-2">Proceed </button>
            </div>

        </form>
        <div class="text-center mt-8">
            <a href="{{url('signout')}}" class="link text-slate-700 float-right text-xs">Cancel / Log Off</a>
        </div>
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