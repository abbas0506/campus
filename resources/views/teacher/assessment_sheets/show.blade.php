@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12">Assessment Sheet</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">Index </a> / {{$course_allocation->course->name}} / {{$course_allocation->section->title()}}
    </div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
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

    @if(session('success'))
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif

    <input type="text" id='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">

    <div class="flex items-center justify-between py-2 mt-8 space-x-5 ">
        <div class="flex flex-col flex-1 text-sm text-green-800 py-3 pr-5">
            <div class="font-bold">{{$course_allocation->course->name}}</div>
            <div>{{$course_allocation->section->title()}}</div>

        </div>
        <a href="{{url('assessment_sheets/pdf', $course_allocation->id)}}" target="_blank" class="px-5 py-2 btn-indigo">
            Print
        </a>
    </div>

    <div class="mt-4 text-slate-600">{{$course_allocation->strength()}} students found</div>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="border-b text-sm">
                <th>Roll No.</th>
                <th>Student Name</th>
                <th class="text-center">Assignment <br> 10%</th>
                <th class="text-center">Presentation <br> 10%</th>
                <!-- <th class='text-center'>Attendance<br> 2%</th> -->
                <th class='text-center'>Midterm<br> 30%</th>
                <th class='text-center'>Formative<br>50%</th>
                <th class='text-center'>Summative<br>50%</th>
                <th class='text-center'>Marks <br> Obtained</th>
                <th class='text-center'>Grade <br>Point</th>
                <th class='text-center'>Grade<br> Letter</th>
                <th class='text-center'>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course_allocation->first_attempts as $first_attempt)
            <tr class="tr border-b text-sm">
                <td>{{$first_attempt->student->rollno}}</td>
                <td>{{$first_attempt->student->name}}</td>
                <td class='text-center'>{{$first_attempt->assignment}}</td>
                <td class='text-center'>{{$first_attempt->presentation}}</td>
                <td class='text-center'>{{$first_attempt->midterm}}</td>
                <td class='text-center'>{{$first_attempt->formative()}}</td>
                <td class='text-center'>{{$first_attempt->summative}}</td>
                <td class='text-center'>{{$first_attempt->summative()}}</td>
                <td class='text-center'>{{$first_attempt->gpa()}}</td>
                <td class='text-center'>{{$first_attempt->grade()}}</td>
                <td class='text-center'>{{$first_attempt->status()}}</td>
            </tr>
            @endforeach
            @foreach($course_allocation->reappears as $reappear)
            <tr class="tr border-b text-sm">
                <td>{{$reappear->first_attempt->student->rollno}}</td>
                <td>{{$reappear->first_attempt->student->name}}</td>
                <td class='text-center'>{{$reappear->first_attempt->assignment}}</td>
                <td class='text-center'>{{$reappear->first_attempt->presentation}}</td>
                <td class='text-center'>{{$reappear->first_attempt->midterm}}</td>
                <td class='text-center'>{{$reappear->first_attempt->formative()}}</td>
                <td class='text-center'>{{$reappear->first_attempt->summative}}</td>
                <td class='text-center'>{{$reappear->first_attempt->summative()}}</td>
                <td class='text-center'>{{$reappear->first_attempt->gpa()}}</td>
                <td class='text-center'>{{$reappear->first_attempt->grade()}}</td>
                <td class='text-center'>{{$reappear->first_attempt->status()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection