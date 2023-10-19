@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <div class="flex flex-wrap justify-between items-center">
        <div>
            <h2>Formative Assessment</h2>
            <div class="bread-crumb">
                <a href="{{route('teacher.assessment.show', $course_allocation)}}">Cancel & Go Back</a>
            </div>
        </div>
        <div class="text-center">
            @if($course_allocation->submitted_at!='')
            <i class="bi-lock text-red-600 text-xl"></i>
            @else
            <i class="bi-unlock text-teal-600 text-xl"></i>
            @endif
            <div>Status</div>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-between space-x-4 mt-8 border border-dashed p-4">
        <div>
            <h2 class='text-red-600'>{{$course_allocation->course->name}}</h2>
            <p>{{$course_allocation->section->title()}}</p>
        </div>
        <div></div>
        <a href="{{route('teacher.assessment.preview', $course_allocation)}}" class="btn-teal text-sm"><i class="bi-eye"></i> &nbsp Preview</a>
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
    <form action="{{route('teacher.formative.update', $course_allocation)}}" method="POST" class='mt-4' onsubmit="return validateBeforeSubmit(event)">
        @csrf
        @method('PATCH')

        <div class="overflow-x-auto w-full">
            <table class="table-fixed w-full">
                <thead>
                    <tr class="border-b border-slate-200 text-sm">
                        <th class="w-8">Sr</th>
                        <th class="w-8"></th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-48 text-left">Father</th>
                        <th class="w-20">Asgn <br> <span class="font-thin">(10%)</span></th>
                        <th class="w-20">Pres<br> <span class="font-thin">(10%)</span></th>
                        <th class="w-20">Mid<br> <span class="font-thin">(30%)</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                    <tr class="tr">
                        <td>{{$sr++}}</td>
                        <td>@if($first_attempt->student->gender=='M')
                            <i class="bx bx-male text-teal-600 text-lg"></i>
                            @else
                            <i class="bx bx-female text-indigo-400 text-lg"></i>
                            @endif
                        </td>
                        <td class="text-left">{{$first_attempt->student->name}}<br>{{$first_attempt->student->rollno}}</td>
                        <td class="text-left">{{$first_attempt->student->father}}</td>
                        <td hidden><input type="text" name='id[]' value="{{$first_attempt->id}}"></td>
                        <td hidden><input type="text" name='attempt_type[]' value="F"></td>
                        <td>
                            <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$first_attempt->assignment}}" placeholder="absent" onchange="validate(event,10)">
                        </td>
                        <td>
                            <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$first_attempt->presentation}}" placeholder="absent" onchange="validate(event,10)">
                        </td>
                        <td>
                            <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$first_attempt->midterm}}" placeholder="absent" onchange="validate(event,30)">
                        </td>
                    </tr>
                    @endforeach

                    <!-- reappear -->
                    @foreach($course_allocation->reappears_sorted() as $reappear)
                    <tr class="tr">
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
                        <td hidden><input type="text" name='id[]' value="{{$reappear->id}}"></td>
                        <td hidden><input type="text" name='attempt_type[]' value="R"></td>
                        <td>
                            <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$reappear->assignment}}" placeholder="absent" onchange="validate(event,10)">
                        </td>
                        <td>
                            <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$reappear->presentation}}" placeholder="absent" onchange="validate(event,10)">
                        </td>
                        <td>
                            <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-16 marks" value="{{$reappear->midterm}}" placeholder="absent" onchange="validate(event,30)">
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn-teal mt-4 float-right">Save Result</button>
    </form>

</div>
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
</script>
@endsection