@extends('layouts.coordinator')
@section('page-content')

<div class="container">
    <h2>Add New Class</h2>
    <div class="bread-crumb">
        <a href="{{url('coordinator')}}">Home</a>
        <div>/</div>
        <a href="{{route('coordinator.clases.index')}}">Current Classes</a>
        <div>/</div>
        <div>Add</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">
        <div class="flex flex-col md:flex-row md:items-center gap-x-4">
            <i class="bi-info-circle text-2xl text-indigo-600"></i>
            <div class="flex-grow text-left sm:mt-0">
                <h2>Please note</h2>
                <ul class="text-sm">
                    <li>First semester means the very first semester (when class started on).</li>
                    <li>If study scheme is missing, it can be defined using one time activity tab</li>
                </ul>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <h1 class='text-red-600 mt-8'>{{$program->short}} <i class="bx bx-chevron-right"></i>New Class</h1>

        <form action="{{route('coordinator.clases.store')}}" method='post' class="mt-8" onsubmit="return validate(event)">
            @csrf
            <input type="text" name="program_id" value="{{$program->id}}" hidden>

            <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-4">
                <div>
                    <label>First Semester (class started on)</label>
                    <select id='first_semester_id' name="first_semester_id" class="custom-input">
                        @foreach($semesters as $semester)
                        <option value="{{$semester->id}}" @selected($semester->id==session('semester_id'))>{{$semester->short()}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Choose Shift</label>
                    <select name="shift_id" class="custom-input">
                        @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{$shift->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Study Scheme for this class?</label>
                    <select id='scheme_id' name="scheme_id" class="custom-input">
                        @foreach($program->schemes as $scheme)
                        <option value="{{$scheme->id}}">{{$scheme->subtitle()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-indigo-rounded mt-6">Create Now</button>

        </form>

    </div>
</div>

@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        var scheme_id = $('#scheme_id').val()

        if (scheme_id == '') {

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