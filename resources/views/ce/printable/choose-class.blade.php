@extends('layouts.controller')
@section('page-content')

<div class="container">
    <h1>Choose Semester & Class</h1>
    <div class="bread-crumb">
        <a href="{{url('controller')}}">Home</a>
        <div>/</div>
        <div>Printable</div>
        <div>/</div>
        <div>Choose Class</div>
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form method='post' action="{{route('controller.printable.clas.allocations')}}" class="mt-4">
        @csrf
        @method('POST')
        <div class="grid grid-cols-1 md:w-1/2 mx-auto gap-1">
            <div class="flex flex-col">
                <label for="">Department</label>
                <select id="department_id" name="department_id" class="custom-input px-4 py-3 w-full" onchange="loadPrograms()">
                    <option value="">Select a department</option>
                    @foreach($departments as $department)
                    <option value="{{$department->id}}">{{Str::replace('Department of ','',$department->name)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label for="">Program</label>
                <select id="program_id" name="program_id" class="custom-input px-4 py-3 w-full" onchange="resetSelection()">

                </select>
            </div>
            <div class="flex flex-col">
                <label for="">Semester</label>
                <select id="semester_id" name="semester_id" class="custom-input px-4 py-3 w-full" onchange="loadClasses()">
                    <option value="">Select a semester</option>
                    @foreach($semesters as $semester)
                    <option value="{{$semester->id}}">{{$semester->short()}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label for="">Class</label>
                <select id="clas_id" name="clas_id" class="custom-input px-4 py-3 w-full">

                </select>
            </div>
            <button type="submit" class="btn-teal rounded mt-4 py-2 px-4">Next</button>
        </div>
    </form>

</div>
@endsection

@section('script')
<script>
    function loadPrograms() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var semester_id = $('#semester_id').val();
        var department_id = $('#department_id').val();

        //fetch concerned department by role
        if (department_id !== '') {
            $.ajax({
                type: 'POST',
                url: "{{url('/controller/fetchProgramsByDepartment')}}",
                data: {
                    "department_id": department_id,
                    "_token": token,
                },
                success: function(response) {
                    //
                    $('#program_id').html(response.options);
                    $('#clas_id').html('');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: errorThrown
                    });
                }
            }); //ajax end
        } //if ends
    } //function ends


    function loadClasses() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");
        var semester_id = $('#semester_id').val();
        var program_id = $('#program_id').val();

        //fetch concerned department by role
        if (semester_id == '' || program_id == '') {
            Swal.fire({
                icon: 'warning',
                text: "Either program or semester missing!"
            });
        } else {
            $.ajax({
                type: 'POST',
                url: "{{url('/controller/fetchClassesByProgram')}}",
                data: {
                    "semester_id": semester_id,
                    "program_id": program_id,
                    "_token": token,
                },
                success: function(response) {
                    //
                    $('#clas_id').html(response.options);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        text: errorThrown
                    });
                }
            }); //ajax end
        } //if ends
    } //function ends

    function resetSelection() {
        // $('#semester_id').selectedIndex = 0;
        document.querySelector('#semester_id').selectedIndex = 0;
        $('#clas_id').html('');
    }
</script>

@endsection