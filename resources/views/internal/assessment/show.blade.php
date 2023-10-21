@extends('layouts.hod')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>Assessment Preview</h2>
            <div class="bread-crumb">
                <a href="{{route('hod.assessment.index')}}">Cancel & Go Back</a>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-between space-x-4 mt-8 border border-dashed p-4">
        <div>
            <h2 class='text-red-600'>{{$course_allocation->course->name}}</h2>
            <p>{{$course_allocation->section->title()}}</p>
        </div>
        <div></div>
        <a href="#" target='_blank' class="btn-teal text-sm"><i class="bi-printer"></i>&nbsp Print</a>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap justify-between items-center mt-4">
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>
        <div class="flex flex-wrap items-center space-x-4 mt-4 text-xs">
            <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                <span class="bx bx-group text-sm rounded-full"></span>
            </div>
            <div>Fresh : {{$course_allocation->first_attempts->count()}}</div>
            <div class="mx-1 text-xs font-thin">|</div>
            <div>Re-Appear : {{$course_allocation->reappears->count()}}</div>
        </div>
    </div>

    @php
    $sr=1;
    @endphp
    <!-- fresh students -->
    <div class="overflow-x-auto w-full mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr class="text-xs">
                    <th class="w-8">Sr</th>
                    <th class="w-8"></th>
                    <th class="w-40 text-left">Name</th>
                    <th class="w-40 text-left">Father</th>
                    <th class="w-12">Att.<br><span class="font-thin">(2%)</span></th>
                    <th class="w-12">Asgn <br> <span class="font-thin">(10%)</span></th>
                    <th class="w-12">Pres <br> <span class="font-thin">(10%)</span></th>
                    <th class="w-12">Mid<br> <span class="font-thin">(30%)</span></th>
                    <th class="w-12">Smt<br> <span class="font-thin">(50%)</span></th>
                    <th class="w-12">Total</th>
                    <th class="w-12">GP</th>
                    <th class="w-12">Grade</th>
                    <th class="w-20">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                <tr class="tr text-xs">
                    <td>{{$sr++}}</td>
                    <td>@if($first_attempt->student->gender=='M')
                        <i class="bx bx-male text-teal-600 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif
                    </td>
                    <td class="text-left">{{$first_attempt->student->name}}<br>{{$first_attempt->student->rollno}}</td>
                    <td class="text-left">{{$first_attempt->student->father}}</td>
                    <td></td>
                    <td>{{$first_attempt->assignment}}</td>
                    <td>{{$first_attempt->presentation}}</td>
                    <td>{{$first_attempt->midterm}}</td>
                    <td>{{$first_attempt->summative}}</td>
                    <td>{{$first_attempt->total()}}</td>
                    <td>{{$first_attempt->gpa()}}</td>
                    <td>{{$first_attempt->grade()}}</td>
                    <td>{{$first_attempt->status()}}</td>
                </tr>
                @endforeach

                <!-- reappear -->
                @foreach($course_allocation->reappears_sorted() as $reappear)
                <tr class="tr text-xs">
                    <td class="text-slate-400">{{$sr++}}</td>
                    <td>
                        @if($reappear->first_attempt->student->gender=='M')
                        <i class="bx bx-male text-teal-600 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif
                    </td>
                    <td class="text-left">{{$reappear->first_attempt->student->name}}<br>{{$reappear->first_attempt->student->rollno}}</td>
                    <td>{{$reappear->first_attempt->student->father}}</td>
                    <td></td>
                    <td>{{$reappear->assignment}}</td>
                    <td>{{$reappear->presentation}}</td>
                    <td>{{$reappear->midterm}}</td>
                    <td>{{$reappear->summative}}</td>
                    <td>{{$reappear->total()}}</td>
                    <td>{{$reappear->gpa()}}</td>
                    <td>{{$reappear->grade()}}</td>
                    <td>{{$reappear->status()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>
@endsection