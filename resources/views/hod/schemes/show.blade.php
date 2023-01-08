@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('schemes.index')}}">Schemes</a></h1>
<div class="bread-crumb">{{$scheme->program->name}} / {{$scheme->subtitle()}}</div>
<div class="container mx-auto">
    @if(session('success'))
    <div class="flex alert-success items-center my-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif

    <div class="flex justify-end">
        <form action="{{route('schemes.destroy',$scheme)}}" method="POST" id='del_form{{$scheme->id}}'>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-red flex items-center justify-center" onclick="delme('{{$scheme->id}}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                <span class="text-sm">Remove scheme</span>
            </button>
        </form>
    </div>

    <table class="table-auto w-full mt-12">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Semester</th>
                <th>Courses</th>
            </tr>
        </thead>
        <tbody>
            @php
            if($scheme){
            $total_semesters=$scheme->program->min_duration*2;
            $semester_no;
            $roman=config('global.romans');
            }
            @endphp
            @foreach($scheme->program->series_of_all_semesters() as $semester_no)
            <tr class="tr">
                <td>Semester {{$roman[$semester_no-1]}}</td>
                <td>
                    @foreach($scheme->scheme_details->where('semester_no',$semester_no) as $scheme_detail)
                    <div class="flex items-center justify-between even:bg-slate-100">
                        <div class="text-sm">{{$scheme_detail->course->name}} <span class="text-xs text-slate-400 ml-3">{{$scheme_detail->course->credit_hrs_theory+$scheme_detail->course->credit_hrs_practical}}({{$scheme_detail->course->credit_hrs_theory}}-{{$scheme_detail->course->credit_hrs_practical}})</span></div>
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

                    <a href="{{route('scheme-details.edit', $semester_no)}}" class="text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
                </td>
            </tr>

            @endforeach

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
</script>

@endsection