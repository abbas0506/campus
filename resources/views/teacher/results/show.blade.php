@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-5">Results</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('mycourses.index')}}" class="text-orange-700 mr-1">My Courses </a> / {{$course_allocation->course->name}} / result
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

    <!-- registered students -->
    <section id='registered' class="mt-16">
        <div class="flex">
            <a href="{{route('results.edit', $course_allocation)}}" class="px-5 py-2 bg-teal-600 text-slate-100">
                Start Editing Result <span class="ml-2">(</span><span class="mx-1">{{$course_allocation->registrations->count()}}</span>)
            </a>
        </div>

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class="text-center">Assignment</th>
                    <th class="text-center">Presentation</th>
                    <th class="text-center">Midterm</th>
                    <th class="text-center">Summative</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->registrations as $registration)
                <tr class="tr border-b ">
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($registration->student->gender=='M')
                                <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                @else
                                <div class="bg-green-500 w-2 h-2 rounded-full"></div>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-600">{{$registration->student->name}}</div>
                                <div class="text-slate-600 text-sm">
                                    {{$registration->student->rollno}}
                                    @if($registration->student->regno)
                                    | {{$registration->student->regno}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td hidden>{{$registration->student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$registration->student->father}}
                    </td>
                    <td class="py-2 text-slate-600 text-sm text-center">
                        {{$registration->assignment}}
                    </td>
                    <td class="py-2 text-slate-600 text-sm text-center">
                        {{$registration->presentation}}
                    </td>
                    <td class="py-2 text-slate-600 text-sm text-center">
                        {{$registration->midterm}}
                    </td>
                    <td class="py-2 text-slate-600 text-sm text-center">
                        {{$registration->summative}}
                    </td>
                </tr>
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

    function updateChkCount() {

        var chkArray = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) chkArray.push(chk.value);
        })
        document.getElementById("chkCount").innerHTML = chkArray.length;
    }
</script>

@endsection