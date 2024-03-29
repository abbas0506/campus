@extends('layouts.teacher')
@section('page-content')
<div class="flex items-center space-x-4 mt-12">
    <h1 class="">Formative Assessment</h1>
    <div>/</div>
    <a href="{{route('fresh_summative.edit', $course_allocation)}}" class="">Summative Assessment</a>
</div>

<a href="{{route('mycourses.show', $course_allocation)}}" class="flex flex-col flex-1 text-sm text-green-800 py-3 pr-5 mt-4">
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

    <input type="text" id='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">

    <!-- fresh students -->
    <form action="{{route('fresh_formative.update', $course_allocation)}}" method="POST" class='mt-12' onsubmit="return validateBeforeSubmit(event)">
        @csrf
        @method('PATCH')
        <div class="flex items-center justify-between py-2 space-x-5 ">
            <div class="flex flex-growtab items-center">
                <div class="tab active">
                    Fresh Students
                    <div class="bullet"></div>
                </div>
                <a href="{{route('reappear_formative.edit',$course_allocation)}}" class="tab hover:cursor-pointer">Reappearing</a>
            </div>

            <div class="flex space-x-4">
                <a href="{{url('assessment_sheets/pdf', $course_allocation->id)}}" target="_blank" class="flex items-center btn-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-200 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Print
                </a>
                <button type="submit" class="px-8 py-2 bg-teal-600 text-slate-100 rounded-sm hover:bg-teal-500">
                    Save Result
                </button>
            </div>

        </div>

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class="text-center text-sm">Assignment <br> <span class="font-thin">(10%)</span></th>
                    <th class="text-center text-sm">Presentation<br> <span class="font-thin">(10%)</span></th>
                    <th class="text-center text-sm">Midterm<br> <span class="font-thin">(30%)</span></th>
                    <th class="text-center text-sm">Formative<br> <span class="font-thin">(50%)</span></th>

                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->first_attempts as $first_attempt)
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
                                    @if($first_attempt->student->regno)
                                    | {{$first_attempt->student->regno}}
                                    @endif
                                </div>
                            </div>

                        </div>

                    </td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$first_attempt->student->father}}
                    </td>
                    <td hidden><input type="text" name='id[]' value="{{$first_attempt->id}}"></td>
                    <td class="py-3 text-center">
                        <input type='text' name='assignment[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$first_attempt->assignment}}" placeholder="absent" onchange="validate(event,10)">
                    </td>
                    <td class="py-3 text-center">
                        <input type="text" name='presentation[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$first_attempt->presentation}}" placeholder="absent" onchange="validate(event,10)">
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