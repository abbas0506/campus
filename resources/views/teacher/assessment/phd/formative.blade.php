@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12 mb-5"><a href="{{route('mycourses.index')}}">My Courses</a><span class="font-thin text-slate-600 text-sm"> &#x23F5; Formative Assessment</span></h1>
<a href="{{route('mycourses.show',$course_allocation)}}" class="text-sm text-sky-800 py-3 hover:text-blue-800">
    <div class="font-bold">{{$course_allocation->course->name}}</div>
    <div>{{$course_allocation->section->title()}}</div>
</a>

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

    <!-- fresh students -->
    <form action="{{route('fresh_formative.update', $course_allocation)}}" method="POST" class='mt-4' onsubmit="return validateBeforeSubmit(event)">
        @csrf
        @method('PATCH')
        <!-- submit button -->
        <div class="flex items-end justify-between">
            <div class="text-teal-800">Fresh Students <span class="text-xs ml-3 text-slate-600">({{$course_allocation->first_attempts->count()}} records found)</span></div>
            <div class="flex space-x-4">
                <!-- <a href="{{url('assessment_sheets/pdf', $course_allocation->id)}}" target="_blank" class="flex items-center btn-teal"> -->
                <a href="{{route('assessment.show', $course_allocation)}}" target="_blank" class="flex items-center btn-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                </a>
                <button type="submit" class="px-8 py-2 bg-teal-600 text-slate-100 rounded-sm hover:bg-teal-500">
                    Save Result
                </button>
            </div>
        </div>

        <table class="table-auto w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class="text-center text-sm">Asgn/Pres/Quiz/Rev <br> <span class="font-thin">(20%)</span></th>
                    <th class="text-center text-sm">Mid<br> <span class="font-thin">(30%)</span></th>
                    <th class="text-center text-sm">Formative<br> <span class="font-thin">(50%)</span></th>

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
                        <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$first_attempt->assignment}}" placeholder="absent" onchange="validate(event,20)">
                    </td>
                    <td class="py-3 text-center" hidden>
                        <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="0" placeholder="absent">
                    </td>
                    <td class="py-3 text-center">
                        <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$first_attempt->midterm}}" placeholder="absent" onchange="validate(event,30)">
                    </td>
                    <td class="py-3 text-center">
                        {{$first_attempt->formative()}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    @if($course_allocation->reappears->count()>0)
    <!-- Reappear cases -->
    <form action="{{route('reappear_formative.update', $course_allocation)}}" method="POST" class="mt-8 border-t border-dashed pt-2" onsubmit="return validateBeforeSubmit(event)">
        @csrf
        @method('PATCH')
        <div class="flex items-end justify-between py-2 space-x-5 ">
            <div class="text-md text-red-800">*Reappearing Cases <span class="text-xs ml-3 text-slate-600">({{$course_allocation->reappears->count()}} records found)</span></div>
            <button type="submit" class="px-8 py-2 bg-teal-600 text-slate-100 rounded-sm hover:bg-teal-500">
                Save Result
            </button>
        </div>

        <table class="table-auto w-full mt-2">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class="text-center text-sm">Asgn/Pres/Quiz/Rev <br> <span class="font-thin">(20%)</span></th>
                    <th class="text-center text-sm">Mid<br> <span class="font-thin">(30%)</span></th>
                    <th class="text-center text-sm">Formative<br> <span class="font-thin">(50%)</span></th>

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
                        <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$reappear->assignment}}" placeholder="absent" onchange="validate(event,20)">
                    </td>
                    <td class="py-3 text-center" hidden>
                        <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="0" placeholder="absent">
                    </td>
                    <td class="py-3 text-center">
                        <input type="text" name='midterm[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$reappear->midterm}}" placeholder="absent" onchange="validate(event,30)">
                    </td>
                    <td class="py-3 text-center">
                        {{$reappear->formative()}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    @endif
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
</script>
@endsection