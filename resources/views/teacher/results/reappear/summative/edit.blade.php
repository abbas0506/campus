@extends('layouts.teacher')
@section('page-content')
<div class="flex items-center space-x-4 mt-12">
    <h1 class="">Summative Assessment</h1>
    <div>/</div>
    <a href="{{route('fresh_formative.edit', $course_allocation)}}" class="">Formative Assessment</a>
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

    <form action="{{route('reappear_summative.update', $course_allocation)}}" method="POST" class='mt-12' onsubmit="return validateBeforeSubmit(event)">
        @csrf
        @method('PATCH')
        <div class="flex items-center justify-between py-2 space-x-5 ">
            <div class="flex flex-growtab items-center">
                <a href="{{route('fresh_summative.edit', $course_allocation)}}" class="tab" onclick="viewFresh()">Fresh Students</a>
                <div class="tab active">
                    Reappearing
                    <div class="bullet"></div>
                </div>
            </div>
            <button type="submit" class="px-8 py-2 bg-teal-600 text-slate-100 rounded-sm hover:bg-teal-500">
                Save Result
            </button>
        </div>

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th class="text-center text-sm">Midterm<br> <span class="font-thin">(50%)</span></th>
                    <th class="text-center text-sm">Summative <br> <span class="font-thin">(50%)</span></th>
                    <th class="text-center text-sm">Total <br> <span class="font-thin">(100)</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->reappears as $reappear)
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
                    <td hidden><input type="text" name='id[]' value="{{$reappear->id}}" @if($reappear->formative() < 17) disabled @endif>
                    </td>

                    @if($reappear->formative() < 25) <!-- midterm failed -->
                        <td class="py-3 text-center text-red-600">{{$reappear->formative()}}</td>
                        <td class="py-3 text-center">
                            <input type="text" name='summative[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value='' disabled>
                        </td>
                        @else

                        <td class="py-3 text-center">{{$reappear->formative()}}</td>
                        <td class="py-3 text-center">
                            <input type="text" name='summative[]' class="outline outline-1 outline-gray-300 text-center py-1 w-24 marks" value="{{$reappear->summative}}" placeholder="absent" onchange="validate(event,50)">
                        </td>
                        <td class="py-3 text-center">
                            {{$reappear->total()}}
                        </td>
                        @endif
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