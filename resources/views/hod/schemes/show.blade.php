@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Schemes</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Program & Schemes</div>
    </div>

    <h1 class="text-red-600 mt-8">{{$scheme->program->short}} <span class="chevron-right mx-1"></span> {{$scheme->subtitle()}}</h1>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap justify-between items-center gap-2 mt-8">
        <div class="flex items-center text-sm bg-teal-100 text-teal-600 font-semibold p-1">Cr Hrs: &nbsp <span class="mr-3 text-slate-600">{{$scheme->slots()->sum('cr')}} / {{$scheme->program->cr}}</span> <span class="bx bx-check-double ml-2"></span></div>
        @role('super')
        <form action="#" method="POST" id='del_form{{$scheme->id}}'>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-red flex items-center justify-center space-x-2 text-sm" onclick="delme('{{$scheme->id}}')">
                <i class="bi-trash3 text-slate-200 "></i>
                <span>Remove</span>
            </button>
        </form>
        @endrole
    </div>

    @php
    $roman=config('global.romans');
    @endphp
    <div class="flex flex-col accordion mt-4">
        @foreach($scheme->semester_nos() as $semester_no)
        @php
        $active='';
        if(session('active_semester_no')!=null){
        if(session('active_semester_no')==$semester_no){
        $active='active';
        }
        }

        @endphp
        <div class="collapsible">
            <div class="head {{$active}}">
                <h2 class="">
                    Semester {{$roman[$semester_no-1]}}
                    <span class="ml-6 text-xs font-thin"> <i class="bi bi-clock"></i> {{$scheme->slots()->for($semester_no)->sum('cr')}}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                <div class="overflow-x-auto w-full">
                    <table class="table-fixed borderless w-full">
                        <thead>
                            <tr>
                                <th class="w-8">Slot</th>
                                <th class="text-left w-48">Course Type & Related Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot)
                            <tr class="even:bg-slate-100">
                                <td class="py-0">
                                    @if(!$scheme->has_allocation() || Auth::user()->hasRole('super'))
                                    <a href="{{route('slots.edit',$slot)}}" class="link">
                                        {{$slot->slot_no}}
                                    </a>
                                    @else
                                    {{$slot->slot_no}}
                                    @endif
                                </td>
                                <td class="py-0">
                                    <table class="w-full">
                                        <tbody>
                                            @foreach($slot->slot_options as $slot_option)
                                            <tr>
                                                <td class="w-48 text-left">{{$slot_option->course_type->name}} <span class="text-xs text-slate-400">({{$slot->cr}})</span></td>
                                                @if($slot_option->course()->exists())
                                                <td class="w-24">{{$slot_option->course->code}}</td>
                                                <td class="w-48 text-left">{{$slot_option->course->name}} <span class="text-xs text-slate-400">{{$slot_option->course->lblCr()}}</span></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(!$scheme->has_allocation() || Auth::user()->hasRole('super'))
                <div class=" w-full mt-3">
                    <a href="{{route('slots.create', [$scheme->id, $semester_no])}}" class="flex items-center btn-blue text-sm float-left">
                        Create Slot
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
                </div>
                @endif
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