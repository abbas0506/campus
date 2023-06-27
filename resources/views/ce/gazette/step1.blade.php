@extends('layouts.controller')
@section('page-content')
<h1 class="mt-12">Gazette | Step 1</h1>

<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">Choose Department</div>

</div>
<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Select a semester</li>
        <li>Select a department</li>
        <li></li>
    </ul>
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

<div class="flex flex-row space-x-8">
    <div class="flex flex-column">
        <form method='post' action="{{route('ce.gazette.step1.store')}}" class="mt-3">
            @csrf
            @method('POST')

            <label for="" class="text-base text-gray-700 text-left w-full">Semester</label>
            <select id="semester_id" name="semester_id" class="input-indigo px-4 py-3 w-full mb-3">
                @foreach($semesters as $semester)
                <option value="{{$semester->id}}">{{$semester->short()}}</option>
                @endforeach
            </select>

            <label for="" class="text-base text-gray-700 text-left w-full">Select a department</label>
            <select id="department_id" name="department_id" class="input-indigo px-4 py-3 w-full" required>
                <option value="">Select a department</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-teal rounded mt-4 py-2 px-4">Submit</button>

            <!-- <h2 class="mt-4">Available Programs</h2>
            <ul id='programs-list' class="p-4 border rounded">
                <li>No program listed</li>
            </ul> -->
        </form>
    </div>
    <!-- <div class="p-3">
        <h2 class="mt-4">Select a department</h2>
        <div class="flex flex-col h-80 overflow-y-auto border mt-2">
            @php $sr=1; @endphp
            @foreach($departments as $department)
            <div class="filterable flex relative items-center px-4 py-1">
                <input type="checkbox" id='chk{{$department->id}}' class="chk hidden">
                <label class="" for='chk{{$department->id}}' onclick="fetchProgramsByDepartmentId()">
                    {{$department->name}}
                    <i class='bx bx-check tick'></i>
                </label>

            </div>
            @endforeach

        </div>

    </div> -->

</div>
<!-- search bar -->
<!-- <div class="flex items-center justify-between mt-8">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
</div>

<div id='semester_container' class="mt-3">
    <label for="" class="text-base text-gray-700 text-left w-full">Semester</label>
    <select id="semester_id" name="semester_id" class="input-indigo px-4 py-3 w-full">
        <option value="">Select a semester</option>
        @foreach($semesters as $semester)
        <option value="{{$semester->id}}">{{$semester->short()}}</option>
        @endforeach
    </select>
</div>

<div id='semester_container' class="mt-3">

</div>

<div class="text-xs font-thin text-slate-600 mt-8 mb-3">{{$departments->count()}} departments found</div>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Sr</th>
            <th>Departments</th>
        </tr>
    </thead>
    <tbody>
        @php $sr=1; @endphp
        @foreach($departments as $department)
        <tr class="tr">
            <td class="text-center">{{$sr++}}</td>
            <td class="hyper hover:underline hover:text-blue-600"><a href="#">{{$department->name}}</a></td>
        </tr>
        @endforeach

    </tbody>
</table> -->

@endsection
@section('script')
<script type="module">
    $(document).ready(function() {
        $('input[type="checkbox"]').on('change', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
            var semester_id = $("#semester_id").val()



            // alert(semester_id + ", " + department_id)
            //fetch concerned department by role

            // $('#deptt_container').slideDown()
            // $('#semester_container').slideDown()



        });


        // function search(event) {
        //     var searchtext = event.target.value.toLowerCase();

        //     var classesToShow = [];
        //     $('.tr').each(function() {
        //         if ($(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)) {
        //             var matched = $(this).attr('class').split(' ');
        //             classesToShow.push(matched[1]);
        //         }
        //     });
        //     var toShow = classesToShow;
        //     var rowid;
        //     $('tbody tr').each(function() {
        //         rowid = $(this).attr('class').split(' ')

        //         if ($.inArray(rowid[0], toShow) >= 0) {
        //             $(this).removeClass('hidden')

        //         } else
        //             $(this).addClass('hidden')
        //     });

        // }
    });
</script>

@endsection