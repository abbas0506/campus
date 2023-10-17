@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <h2>Results</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('teacher.mycourses.index')}}">My Courses</a>
        <div>/</div>
        <a href="{{route('teacher.mycourses.show',$course_allocation)}}">{{$course_allocation->course->code}}</a>
        <div>/</div>
        <div>Formative</div>
    </div>

    <div class="flex flex-col md:items-center md:flex-row gap-y-4 mt-8">
        <div class="flex-1">
            <h1 class="text-red-600">{{$course_allocation->course->name}}</h1>
            <div class="text-sm">{{$course_allocation->section->title()}}</div>
        </div>
        <div class="md:w-60">
            <div class="pallet-box border">
                <div class="flex-1">
                    <div class="title">Result Progress</div>
                    <h2>0%</h2>
                </div>
                <div class="ico ml-8 bg-blue-100">
                    <i class="bi-graph-up text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <!-- search -->
        <div class="flex relative w-full md:w-1/3 mt-8">
            <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- fresh students -->
        <form id="tab_fresh" action="{{route('teacher.fresh_formative.update', $course_allocation)}}" method="POST" class='mt-8' onsubmit="return validateBeforeSubmit(event)">
            @csrf
            @method('PATCH')
            <!-- submit button -->
            <div class="flex items-end justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                        <span class="bx bx-group rounded-full"></span>
                    </div>
                    <div class="tab active">Fresh : {{$course_allocation->first_attempts->count()}}</div>
                    <div class="mx-1 text-xs font-thin">|</div>
                    <div class="tab" @if($course_allocation->reappears->count()>0) onclick="toggle('f')" @endif>Re-Appear : {{$course_allocation->reappears->count()}}</div>
                </div>
                @if($course_allocation->first_attempts->count()>0)
                <button type="submit" class="btn-teal">Save Result</button>
                @endif
            </div>

            <div class="overflow-x-auto w-full mt-4">
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="border-b border-slate-200 text-sm">
                            <th class="w-48">Name</th>
                            <th class="w-48">Father</th>
                            <th class="text-center w-32">Asgn/Pres/Quiz/Rev <br> <span class="font-thin">(20%)</span></th>
                            <th class="text-center w-24">Mid<br> <span class="font-thin">(30%)</span></th>
                            <th class="text-center w-24">Formative<br> <span class="font-thin">(50%)</span></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                        <tr class="tr border-b ">
                            <td class="py-2">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        @if($first_attempt->student->gender=='M')
                                        <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                        @else
                                        <div class="bg-green-500 w-2 h-2 rounded-full"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-slate-600">{{$first_attempt->student->name}}</div>
                                        <div class="text-slate-600 text-sm">
                                            {{$first_attempt->student->rollno}}
                                        </div>
                                    </div>

                                </div>

                            </td>
                            <td class="py-2 text-slate-600 text-sm">
                                {{$first_attempt->student->father}}
                            </td>
                            <td hidden><input type="text" name='id[]' value="{{$first_attempt->id}}"></td>
                            <td class="py-3 text-center">
                                <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="{{$first_attempt->assignment}}" placeholder="absent" onchange="validate(event,20)">
                            </td>
                            <td class="py-3 text-center" hidden>
                                <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="0" placeholder="absent">
                            </td>
                            <td class="py-3 text-center">
                                <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="{{$first_attempt->midterm}}" placeholder="absent" onchange="validate(event,30)">
                            </td>
                            <td class="py-3 text-center">
                                {{$first_attempt->formative()}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Reappear cases -->
        <form id='tab_reappear' action="{{route('teacher.reappear_formative.update', $course_allocation)}}" method="POST" class="mt-8 hidden" onsubmit="return validateBeforeSubmit(event)">
            @csrf
            @method('PATCH')
            <div class="flex items-end justify-between py-2 space-x-5 ">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                        <span class="bx bx-group rounded-full"></span>
                    </div>
                    <div class="tab active">Re-Appear : {{$course_allocation->reappears->count()}}</div>
                    <div class="mx-1 text-xs font-thin">|</div>
                    <div class="tab" @if($course_allocation->first_attempts->count()>0) onclick="toggle('r')" @endif>Fresh : {{$course_allocation->first_attempts->count()}}</div>
                </div>
                @if($course_allocation->reappears->count()>0)
                <button type="submit" class="btn-teal">Save Result</button>
                @endif
            </div>

            <div class="overflow-x-auto w-full mt-4">
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="border-b border-slate-200 text-sm">
                            <th class="w-48">Name</th>
                            <th class="w-48">Father</th>
                            <th class="text-center w-32">Asgn/Pres/Quiz/Rev <br> <span class="font-thin">(20%)</span></th>
                            <th class="text-center w-24">Mid<br> <span class="font-thin">(30%)</span></th>
                            <th class="text-center w-24">Formative<br> <span class="font-thin">(50%)</span></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course_allocation->reappears_sorted() as $reappear)
                        <tr class="tr border-b ">
                            <td class="py-2">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        @if($reappear->first_attempt->student->gender=='M')
                                        <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                        @else
                                        <div class="bg-green-500 w-2 h-2 rounded-full"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-slate-600">{{$reappear->first_attempt->student->name}}</div>
                                        <div class="text-slate-600 text-sm">
                                            {{$reappear->first_attempt->student->rollno}}
                                            @if($reappear->first_attempt->student->regno)
                                            | {{$reappear->first_attempt->student->regno}}
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </td>
                            <td class="py-2 text-slate-600 text-sm">
                                {{$reappear->first_attempt->student->father}}
                            </td>
                            <td hidden><input type="text" name='id[]' value="{{$reappear->id}}"></td>
                            <td class="py-3 text-center">
                                <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="{{$reappear->assignment}}" placeholder="absent" onchange="validate(event,20)">
                            </td>
                            <td class="py-3 text-center" hidden>
                                <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="0" placeholder="absent">
                            </td>
                            <td class="py-3 text-center">
                                <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-20 marks" value="{{$reappear->midterm}}" placeholder="absent" onchange="validate(event,30)">
                            </td>
                            <td class="py-3 text-center">
                                {{$reappear->formative()}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
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

    function validate(event, max) {
        var input = $(event.target).val();

        if ($.trim(input) == '') {
            // blue border if absent
            $(event.target).addClass('border border-indigo-500');
        } else if ($.isNumeric(input)) {
            //red border if invalid value
            if (input < 0 || input > max)
                $(event.target).addClass('border border-red-500');
            else if ($(event.target).hasClass('border-red-500'))
                $(event.target).removeClass('border border-red-500');
            else if ($(event.target).hasClass('border-indigo-500'))
                $(event.target).removeClass('border border-indigo-500');

        } else {
            //red border if character input
            $(event.target).addClass('border border-red-500');
        }
    }

    function validateBeforeSubmit(event) {
        var validated = true;
        $(".marks").each(function() {
            if ($(this).hasClass('border-red-500')) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid marks!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                event.preventDefault();
                validated = false;
            }
            return validated;
        });
    }

    function toggle(opt) {
        if (opt == 'f') {
            $('#tab_fresh').slideUp();
            $('#tab_reappear').slideDown();
        }
        if (opt == 'r') {
            $('#tab_fresh').slideDown();
            $('#tab_reappear').slideUp();
        }
    }
</script>
@endsection