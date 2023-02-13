@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12">Assessment Sheet</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$course_allocation->section->title()}}<br>{{$course_allocation->course->name}}
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

    <div class="flex items-center flex-wrap justify-between">
        <div class="text-slate-400 text-sm mt-12 font-thin">{{$course_allocation->strength()}} students found</div>
        <a href="{{url('assessment_sheets/pdf', $course_allocation->id)}}" target="_blank" class="flex items-center btn-teal">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-200 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Print
        </a>
    </div>


    <table class="table-auto w-full mt-2">
        <thead>
            <tr class="border-b text-sm">
                <th class="text-center border">Roll No.</th>
                <th class="border">Student Name</th>
                <th class="text-center border">Assignment <br> 10%</th>
                <th class="text-center border">Presentation <br> 10%</th>
                <!-- <th class='text-center border'>Attendance<br> 2%</th> -->
                <th class='text-center border'>Midterm<br> 30%</th>
                <th class='text-center border'>Formative<br>50%</th>
                <th class='text-center border'>Summative<br>50%</th>
                <th class='text-center border'>Marks <br> Obtained</th>
                <th class='text-center border'>Grade <br>Point</th>
                <th class='text-center border'>Grade<br> Letter</th>
                <th class='text-center border'>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course_allocation->first_attempts as $first_attempt)
            <tr class="tr border-b text-sm">
                <td class="text-center border">{{$first_attempt->student->rollno}}</td>
                <td class="border pl-1">{{$first_attempt->student->name}}</td>
                <td class='text-center border'>{{$first_attempt->assignment}}</td>
                <td class='text-center border'>{{$first_attempt->presentation}}</td>
                <td class='text-center border'>{{$first_attempt->midterm}}</td>
                <td class='text-center border'>{{$first_attempt->formative()}}</td>
                <td class='text-center border'>{{$first_attempt->summative}}</td>
                <td class='text-center border'>{{$first_attempt->total()}}</td>
                <td class='text-center border'>{{$first_attempt->gpa()}}</td>
                <td class='text-center border'>{{$first_attempt->grade()}}</td>
                <td class='text-center border'>{{$first_attempt->status()}}</td>
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
                <td class='text-center'>{{$reappear->first_attempt->total()}}</td>
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