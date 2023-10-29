@extends('layouts.basic')

@section('body')


<div class="flex justify-center items-center w-screen h-screen bg-gradient-to-b from-blue-100 to-blue-400">
    <div class="md:w-1/3 p-5"><!-- page message -->

        <h1 class="text-xl">Switch me to ...</h1>
        <p class="text-sm">Please select any of the following available options and press on switch now button</p>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('switch.me')}}" method="post" class="mt-2">
            @csrf
            <select id='role' name="role" class="custom-input bg-transparent py-0" onchange="loadDepartments()">
                @foreach($roles as $role)
                <option value="{{$role->name}}" class='py-0' @selected($role->name==session('role'))>{{ucfirst($role->name)}}</option>
                @endforeach
            </select>
            @if(session('role')=='teacher')
            <!-- department is required only if previous role is teacher  -->
            <div id='deptt_container' class="hidden">
                <div class="mt-3">
                    <select id="department_id" name="department_id" class="custom-input px-4 py-0 ">

                    </select>
                </div>
            </div>
            @endif
            <select name="semester_id" class="custom-input bg-transparent">
                @foreach($semesters as $semester)
                <option value="{{$semester->id}}" @selected($semester->id==session('semester_id'))>{{$semester->short()}}</option>
                @endforeach
            </select>
            <div class="flex flex-wrap items-center gap-x-4 mt-4">
                <a href="{{url(session('role'))}}" class="btn-blue flex-1 text-center">Cancel</a>
                <button type="submit" class="btn-orange flex-1">Switch Now</button>
            </div>
        </form>

    </div>

</div>

@endsection
@section('script')
<script>
    function loadDepartments() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var role = $('#role').val();
        if (role != 'teacher') {
            //fetch concerned department by role
            $.ajax({
                type: 'POST',
                url: "{{route('fetchDepttByRole')}}",
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
</script>
@endsection