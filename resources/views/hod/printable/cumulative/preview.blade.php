@extends('layouts.hod')
@section('page-content')
<h1>Cumulative Sheet | Preview</h1>
<p class="">{{$section->title()}}</p>
<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="">
        <li>Click on any program, sections will appear</li>
        <li>Click on any section to see or print award lists of the section</li>
        <li></li>
    </ul>
</div>

<!-- records found -->
<div class=" font-thin text-slate-600 mt-8 mb-3">{{$section->course_allocations->count()}} courses found</div>
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

<div class="flex items-center flex-wrap justify-between">
    <div class="text-slate-400 text-sm mt-12 font-thin">{{$section->students->count()}} students found</div>
    <a href="" target="_blank" class="flex items-center btn-teal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-200 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
        </svg>
        Print
    </a>
</div>
<div class="">
    <div class="flex items-center font-semibold border-b text-[10px]">
        <div class="text-center w-24">Roll No</div>
        <div class="text-center w-20">Reg No</div>
        <div class="w-32">Student Name</div>
        <div class="w-32">Father</div>
        @foreach ($course_allocations as $course_allocation)
        <div class="flex flex-col justify-center items-center">
            <div>{{$course_allocation->course->short}}</div>
            <div>{{$course_allocation->course->code}}</div>
            <div class="flex w-24">
                <div class="text-center w-8 border-l">
                    Marks
                </div>
                <div class="text-center w-8">
                    GP
                </div>
                <div class="text-center w-8">
                    Grade
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div>
        @foreach($section->students->sortBy('rollno') as $student)
        <div class="tr flex items-center border-b text-[10px]">
            <div class="text-center w-24">{{$student->rollno}}</div>
            <div class="text-center w-20">{{$student->regno}}</div>
            <div class="w-32">{{$student->name}}</div>
            <div class="w-32">{{$student->father}}</div>
            @foreach ($course_allocations as $course_allocation)
            @php $attempt=$student->first_attempts()->during(session('semester_id'))->where('course_allocation_id', $course_allocation->id)->first(); @endphp
            <div class="text-center w-8 border-l">
                @if($attempt)
                {{$attempt->obtained()}}
                @endif
            </div>
            <div class="text-center w-8">
                @if($attempt)
                {{$attempt->gpa()}}
                @endif
            </div>
            <div class="text-center w-8">
                @if($attempt)
                {{$attempt->grade()}}
                @endif
            </div>
            @endforeach
            <!-- course total ends -->
            <div class="text-center w-8 border-l">
                @if($attempt)
                {{$student->sum_of_obtained()}}
                @endif
            </div>
            <div class="text-center w-8">
                @if($attempt)
                {{$student->cgpa()}}
                @endif
            </div>
            <div class="text-center w-8">
                @if($attempt)
                grade
                @endif
            </div>
        </div>
        @endforeach


    </div>
</div>
@endsection
@section('script')
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