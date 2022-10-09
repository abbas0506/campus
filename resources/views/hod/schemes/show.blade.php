@extends('layouts.hod')
@section('page-content')
<div class="container px-16">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mb-5 md:my-16">
            <h1 class="text-indigo-500 text-xl">Scheme {{$scheme->semester->year}} | {{$scheme->program->short}}</h1>
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
                <th>Semester</th>
                <th>Program</th>
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
                <td class="flex py-2">
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
                        <div class="text-sm">{{$scheme_detail->course->name}}</div>
                        <form action="{{route('scheme-details.destroy',$scheme_detail)}}" method="POST" id='del_form{{$scheme_detail->id}}' class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0 text-red-600" onclick="delme('{{$scheme_detail->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </button>
                        </form>

                    </div>
                    @endforeach

                    <a href="{{route('scheme-details.edit', $semester_no)}}" class="flex items-center justify-end text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
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