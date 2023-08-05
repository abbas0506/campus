@extends('layouts.hod')
@section('page-content')
<h1><a href="{{route('programs.index')}}">Study Scheme</a></h1>
<div class="bread-crumb">{{$scheme->program->name}} / schemes / {{$scheme->subtitle()}}</div>

<div class="flex items-center mt-8">
    <a href="{{route('schemes.index')}}" class="link">Schemes</a>
    <span class="chevron-right mx-1"></span>
    <h2>{{$scheme->program->short}}</h2>
    <span class="chevron-right mx-1"></span>
    <span>{{$scheme->subtitle()}}</span>
</div>

<div class="container mx-auto">


    @if ($errors->any())
    <div class="alert-danger text-sm w-full mb-3">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="flex alert-success items-center my-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif

    <div class="flex justify-between items-center mt-8">
        <div class="flex items-center text-sm bg-teal-100 text-teal-600 font-semibold py-1 px-2">Cr Hrs: <span class="p-1 ml-2 mr-5 text-slate-600">{{$scheme->slots()->sum('cr')}} / {{$scheme->program->cr}}</span> <span class="bx bx-check-double ml-2"></span></div>
        <!-- <form action="{{route('schemes.destroy',$scheme)}}" method="POST" id='del_form{{$scheme->id}}'> -->
        @role('super')
        <form action="#" method="POST" id='del_form{{$scheme->id}}'>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-red flex items-center justify-center" onclick="delme('{{$scheme->id}}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                <span class="text-sm">Remove scheme</span>
            </button>
        </form>
        @endrole
    </div>

    @php
    $roman=config('global.romans');
    @endphp
    <div class="flex flex-col accordion mt-4">
        @foreach($semester_nos as $semester_no)
        <div class="collapsible">
            <div class="head">
                <h2 class="">
                    Semester {{$roman[$semester_no-1]}}
                    <span class="ml-6 text-xs font-thin"> <i class="bi bi-clock"></i> {{$scheme->slots()->for($semester_no)->sum('cr')}}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <!-- show header only if some scheme meta entries exist  -->
                @if($scheme->slots()->for($semester_no)->count()>0)
                <div class="flex items-center w-full font-medium border-b pb-1">
                    <div class="text-sm w-36">Slot</div>
                    <div class="text-sm text-center w-16">Cr</div>
                    <div class="text-sm flex-1">Course Type</div>
                    <div class="text-sm text-center w-16">Action</div>

                    <!-- <div class="flex items-center flex-1 text-indigo-600">List of Courses <span class="ml-1 text-xs"> (Will be purely tentaive; You may not follow it during course allocation, if desired) </span></div>
                    <div class="">Action</div> -->
                </div>
                @endif
                @foreach($scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot)
                <div class="flex items-center w-full py-1 odd:bg-slate-100">
                    <form action="{{route('slots.update', $slot)}}" method="post" class="flex items-center space-x-2 w-36">
                        @csrf
                        @method('PATCH')
                        <input type="number" name='slot_no' min='0' max="8" value="{{$slot->slot_no}}" class="w-6 mr-2">
                        <button type="submit" class="btn-orange text-xs px-2 rounded-sm">Update</button>
                    </form>

                    <div class="text-sm text-center w-16">{{$slot->cr}}</div>
                    <div class="text-sm flex-1">
                        {{$slot->lblCrsType()}}
                    </div>
                    <div class="flex items-center justify-center flex-wrap w-16 space-x-4 ">
                        <a href="{{route('slots.edit',$slot)}}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @role('super')
                        <form action="{{route('slots.destroy',$slot)}}" method="POST" id='del_form{{$slot->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-0 text-xs" onclick="delme('{{$slot->id}}')"><i class="bi bi-trash3"></i></button>
                        </form>
                        @endrole
                    </div>

                </div>
                @endforeach

                <div class=" w-full border-t border-b border-dashed py-2">
                    <a href="{{route('slots.create', [$scheme->id, $semester_no])}}" class="flex items-center btn-blue text-sm float-left">
                        Create Slot
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
                </div>


            </div>

        </div>

        @endforeach
    </div>
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