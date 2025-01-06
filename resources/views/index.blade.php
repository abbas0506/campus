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

        <div class="text-center">
            <img class="md:w-3/4 mx-auto" alt="logo" src="{{asset('/images/logo/logo.png')}}">
            <h1 class="text-2xl md:text-4xl text-indigo-900 font-culpa font-thin tracking-widest">Exam Portal</h1>
        </div>

        <div class="w-full">

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <!-- <h3 class="text-xs">Not a user? Please, contact system admin!</h3> -->
            <form action="{{url('login')}}" method="post" class="w-full mt-8">
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
                    <button type="submit" class="w-full mt-4 btn-indigo p-2">Login</button>

                </div>
            </form>
        </div>
        <div class="text-center mt-8">
            <a href="{{url('password/forgot')}}" class="link text-slate-700 float-right text-xs">Forgot password?</a>
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