@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Classes</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('clases.index')}}"> Classes </a> / new
    </div>
</div>

<div class="container md:w-3/4 mx-auto px-5">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route('clases.store')}}" method='post' class="flex flex-col w-full mt-16" onsubmit="return validate(event)">
        @csrf

        <label for="" class='mt-8'>Program</label>
        <select id="program_id" name="program_id" class="input-indigo p-2" onchange="loadSchemes()">
            <option value="">Select a program</option>
            @foreach($programs as $program)
            <option value="{{$program->id}}">{{$program->name}}</option>
            @endforeach
        </select>

        <div class="flex items-center space-x-4">
            <div class="flex flex-col">
                <label for="" class="mt-5">Shift</label>
                <select id="shift_id" name="shift_id" class="input-indigo p-2">
                    @foreach($shifts as $shift)
                    <option value="{{$shift->id}}">{{$shift->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label for="" class="mt-5">Semester No.</label>
                <select id='semester_no' name="semester_no" class="input-indigo p-2">

                </select>
            </div>
            <div class="flex flex-col grow">
                <label for="" class="mt-5">Scheme to apply</label>
                <select id='scheme_id' name="scheme_id" class="input-indigo p-2">

                </select>
            </div>
        </div>
        </select>

        <div class="flex items-center justify-end space-x-4 mt-8 py-2 bg-indigo-50">
            <a href="{{route('clases.index')}}" class="btn-indigo-rounded">Cancel</a>
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection
@section('script')
<script lang="javascript">
    function clearSelection() {
        $('#program_id').val("");
        $('#scheme_id').val("");
    }

    function loadSchemes() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var program_id = $('#program_id').val();
        $.ajax({
            type: 'POST',
            url: "/fetchSchemesByProgramId",
            data: {
                "program_id": program_id,
                "_token": token,

            },
            success: function(response) {
                //
                $('#scheme_id').html(response.scheme_options);
                $('#semester_no').html(response.semester_nos);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'warning',
                    title: errorThrown
                });
            }
        }); //ajax end
    }

    function validate(event) {
        var validated = true;
        var program_id = $('#program_id').val()
        var semester_no = $('#semester_no').val()
        var scheme_id = $('#scheme_id').val()


        if (program_id == '' || semester_no == '' || scheme_id == '') {

            event.preventDefault();
            validated = false;

            Swal.fire({
                icon: 'warning',
                title: 'Required input missing!',
                showConfirmButton: false,
                timer: 1500,
            })

        }
        return validated;

    }
</script>
@endsection