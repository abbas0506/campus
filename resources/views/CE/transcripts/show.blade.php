@extends('layouts.controller')
@section('page-content')
<h1 class="mt-8">Transcript</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">Transcripts </a> / {{$student->name}} / {{$student->rollno}}
    </div>
</div>

<div class="container w-full mx-auto mt-8">
    <section id='registered' class="">
        <div class="flex justify-end border-b pb-4">
            <a href="{{url('transcripts/pdf', $student)}}" class="px-8 py-2 bg-teal-600 text-slate-100" target="_blank">
                Print
            </a>
        </div>
        <div class="flex mt-8">
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Program Name</div>
            <div class="flex w-2/6 py-2">{{$student->section->clas->program->name}}</div>
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Session</div>
            <div class="flex w-2/6 py-2">{{$student->session()}}</div>
        </div>
        <div class="flex">
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Candidate Name</div>
            <div class="flex w-2/6 py-2">{{$student->name}}</div>
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Roll No.</div>
            <div class="flex w-2/6 py-2">{{$student->rollno}}</div>
        </div>
        <div class="flex">
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Father Name</div>
            <div class="flex w-2/6 py-2">{{$student->father}}</div>
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Registration No.</div>
            <div class="flex w-2/6 py-2">{{$student->regno}}</div>
        </div>

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border pl-2">Course Code</th>
                    <th class="border pl-2">Course Title</th>
                    <th class="text-center border">Credit Hrs</th>
                    <th class="text-center border">Obtaied Marks out of 100</th>
                    <th class="text-center border">Grade Point</th>
                    <th class="text-center border">Grade Letter</th>
                </tr>
            </thead>
            @php
            $roman = config('global.romans');
            @endphp
            <tbody>
                @foreach($semester_nos as $semester_no)
                <tr>
                    <td colspan="6">Semester-{{$roman[$semester_no-1]}}</td>
                </tr>
                @foreach($first_attempts->where('semester_no',$semester_no) as $first_attempt)

                <tr class="tr">
                    <td class="py-1 pl-2 border">{{$first_attempt->course->code}}</td>
                    <td class="py-1 pl-2 border">{{$first_attempt->course->name}}</td>
                    <td class="py-1 text-center border">{{$first_attempt->course->creditHrs()}}</td>
                    <td class="py-1 text-center border">{{$first_attempt->best_attempt()->summative()}}</td>
                    <td class="py-1 text-center border">{{$first_attempt->best_attempt()->gp()}}</td>
                    <td class="py-1 text-center border">{{$first_attempt->best_attempt()->grade()}}</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </section>
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