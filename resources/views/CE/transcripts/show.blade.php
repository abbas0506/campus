@extends('layouts.controller')
@section('page-content')
<h1 class="mt-8">Transcript</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">Transcripts </a> / {{$student->name}} / {{$student->rollno}}
    </div>
</div>

<div class="flex justify-center items-center text-2xl font-bold w-full py-1 mt-24 relative">
    <div class="absolute left-0 z-5">
        <img alt="logo" src="{{asset('/images/logo/logo-light.png')}}" class="w-36">
    </div>
    University of Okara
</div>
<h1 class="mt-5 font-bold text-center">Transcript</h1>

<div class="container w-full mx-auto mt-8">
    <section id='registered' class="">
        <div class="flex justify-end border-b pb-4">
            <a href="{{url('transcripts/pdf', $student)}}" class="px-8 py-2 bg-teal-600 text-slate-100" target="_blank">
                Print
            </a>
        </div>
        <div class="flex mt-8">
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Program Name</div>
            <div class="flex w-2/6 py-2">{{$student->section->program->name}}</div>
            <div class="flex w-1/6 py-2 text-gray-800 font-bold">Session</div>
            <div class="flex w-2/6 py-2">2022-24</div>
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
            <tbody>
                @foreach($semester_nos as $semester_no)
                <tr>
                    <td colspan="6">Semester-{{$semester_no}}</td>
                </tr>
                @foreach($results->where('semester_no',$semester_no) as $result)

                <tr class="tr">
                    <td class="py-1 pl-2 border">{{$result->course_allocation->course->code}}</td>
                    <td class="py-1 pl-2 border">{{$result->course_allocation->course->name}}</td>
                    <td class="py-1 text-center border">{{$result->creditHrs()}}</td>
                    <td class="py-1 text-center border">{{$result->obtained()}}</td>
                    <td class="py-1 text-center border">{{$result->gradePoint()}}</td>
                    <td class="py-1 text-center border">{{$result->gradeLetter()}}</td>
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