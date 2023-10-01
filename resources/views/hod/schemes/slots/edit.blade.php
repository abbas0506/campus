@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Edit Slot</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('schemes.index')}}">Programs & Schemes</a>
        <div>/</div>
        <a href="{{route('schemes.show', $slot->scheme)}}">{{$slot->scheme->subtitle()}}</a>
        <div>/</div>
        <div>Edit Slot</div>
    </div>

    @php
    $roman = config('global.romans');
    @endphp

    <div class="mt-12">
        <div class="flex items-center">
            <h2>{{$slot->scheme->program->short}}</h2>
            <span class="chevron-right mx-1"></span>
            <a href="{{route('schemes.show', $slot->scheme)}}" class="flex items-center text-blue-600 link">
                {{$slot->scheme->subtitle()}}
                (Semester-{{$roman[$slot->semester_no-1]}})
            </a>
        </div>
        <h1 class="text-red-600 mt-2">Slot # {{$slot->slot_no}} ___ <i class="bi-clock"></i> {{$slot->cr}}</h1>

        <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
            <i class="bi bi-info-circle text-2xl"></i>
            <ul class="text-sm ml-4">
                <li>Please specify which type of course will be taught on this slot</li>
                <li>You can specify single or multiple course types against the slot </li>
            </ul>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <h2 class="flex items-center justify-between mt-8">
            <div class="flex items-center">
                <div class="flex justify-center items-center w-7 h-7 bg-teal-100 rounded-full ring-1 ring-teal-200 ring-offset-2 mr-4"><i class="bi-hand-index rotate-180 text-[16px]"></i></div>
                <div>Slot Detail</div>
            </div>
            @if($slot->course_allocations()->count()==0 || Auth::user()->hasRole('super'))
            <form action="{{route('slots.destroy',$slot)}}" method="POST" id='del_form{{$slot->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-red py-0 text-xs" onclick="delme('{{$slot->id}}')">Remove Slot</button>
            </form>
            @endif
        </h2>

        <div class="overflow-x-auto mt-4">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <th class="w-48">Course Type</th>
                        <th class="w-48">Course Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slot->slot_options as $slot_option)
                    <tr>
                        <td class="text-left">
                            <div class="flex justify-between flex-nowrap">
                                <div>
                                    {{$slot_option->course_type->name}} <span class="text-slate-400 text-xs">({{$slot_option->slot->cr}})</span>
                                </div>
                                <div>
                                    <form action="{{route('slot-options.destroy',$slot_option)}}" method="POST" id='del_form{{$slot_option->id}}'>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="py-0 text-xs text-red-600" onclick="delme('{{$slot_option->id}}')">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if(!$slot_option->course)
                            <a href="{{route('slot-options.edit', $slot_option)}}" class="flex items-center justify-center link"><i class="bi-link-45deg text-[24px]"></i> <span class="text-xs text-slate-600">(select course)</span></a>
                            @else
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{route('slot-options.edit', $slot_option)}}" class="link">{{$slot_option->course->code}} {{$slot_option->course->name}} {{$slot_option->course->lblCr()}} </a>
                                <form action="{{route('slot-options.update',$slot_option)}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="course_id" value="" class="hidden">
                                    <button type="submit" class="">
                                        <i class="bi-x"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            <div class="collapsible">
                <div class="head">
                    <div>Add a course type to this slot</div>
                    <div><i class="bi-plus"></i></div>
                </div>
                <div class="body">
                    <div class="flex flex-wrap gap-4">
                        @foreach($missing_course_types as $course_type)
                        <form action="{{route('slot-options.store')}}" method='post'>
                            @csrf
                            <input type="hidden" name="slot_id" value="{{$slot->id}}">
                            <input type="hidden" name="course_type_id" value="{{$course_type->id}}">
                            <button type="submit" class="btn-blue">{{ $course_type->name }}</button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    @endsection
    @section('script')
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