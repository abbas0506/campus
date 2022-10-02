@extends('layouts.hod')
@section('page-content')
<div class="container px-16">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mb-5 md:my-16">
            <h1 class="text-indigo-500 text-xl">Course Allocation <span class="text-sm text-slate-500">| {{$scheme->program->short}} | {{session('semester')->semester_type->name}} {{session('semester')->year}}</span> </h1>
        </div>
        <!-- serach field -->
        <div class="relative ml-0 md:ml-20">
            <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>
    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif


    <table class="table-auto w-full">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="py-2 text-gray-600 text-left">Semester</th>
                <th class="py-2 text-gray-600 text-left">Program</th>
            </tr>
        </thead>
        <tbody>
            @php
            if($scheme){
            $total_semesters=$scheme->program->duration*2;
            $semester_no;
            }
            @endphp
            @for($semester_no=1;$semester_no<=$total_semesters;$semester_no++) <tr class="tr border-b">
                <td class="py-2">
                    Semester {{$semester_no}}
                </td>

                <td class="">
                    @php
                    $alternate_row=0;
                    @endphp

                    @foreach($scheme->scheme_details->where('semester_no',$semester_no) as $scheme_detail)

                    @php
                    $alternate_row++;
                    @endphp
                    <div class="flex items-center justify-between @if($alternate_row%2==0) bg-slate-100 @endif">
                        <div class="flex flex-1 text-sm">
                            {{$scheme_detail->course->name}}

                        </div>
                        <div class="flex text-sm justify-end">
                            abbas
                            <a href="{{route('course-allocations.edit', $scheme_detail)}}" class="flex items-center justify-end text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                </svg>

                            </a>
                        </div>
                    </div>
                    @endforeach

                </td>
                </tr>

                @endfor

        </tbody>
    </table>
</div>

<script type="text/javascript">
    function delme(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_form' + formid).submit();
            }
        });
    }

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