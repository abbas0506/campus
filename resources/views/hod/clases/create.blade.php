@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('clases.index')}}"> Classes</a></h1>
<div class="bread-crumb">{{$program->name}} / {{$shift->name}} / New class</div>

<div class="container md:w-3/4 mx-auto px-5">

    <div class="flex items-center flex-row mt-12">
        <div class="h-16 w-16 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
        </div>
        <div class="flex-grow sm:text-left text-center sm:mt-0">
            <h2>Choose Class Semester & Scheme</h2>
            <p class="text-sm">By default, first semester and most suitable scheme is selected, however, you may change them as well</p>
            <p class="text-sm"></p>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="flex items-center alert-danger mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('error')}}
    </div>
    @endif

    <form action="{{route('clases.store')}}" method='post' class="flex flex-col w-full mt-8" onsubmit="return validate(event)">
        @csrf

        <label for="" class='mt-8 text-md text-red-600 font-thin'>{{$program->name}} | {{$shift->name}}</label>
        <input type="text" name="program_id" value="{{$program->id}}" hidden>
        <input type="text" name="shift_id" value="{{$shift->id}}" hidden>

        <div class="flex items-center space-x-4">
            <div class="flex flex-col">
                <label for="" class="mt-5">Semester No.</label>
                <select id='semester_no' name="semester_no" class="input-indigo p-2">
                    @foreach($program->series_of_all_semesters() as $sr)
                    <option value="{{$sr}}">{{$sr}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class="mt-5">Scheme to apply</label>
                <select id='scheme_id' name="scheme_id" class="input-indigo p-2">
                    @foreach($program->schemes as $scheme)
                    <option value="{{$scheme->id}}">{{$scheme->subtitle()}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </select>

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        var semester_no = $('#semester_no').val()
        var scheme_id = $('#scheme_id').val()


        if (semester_no == '' || scheme_id == '') {

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