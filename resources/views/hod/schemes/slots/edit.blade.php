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

    <div class="w-full md:w-3/4 mx-auto mt-12">
        <h1 class="text-red-600">Slot # {{$slot->slot_no}}</h1>
        <div class="flex items-center">
            <h2>{{$slot->scheme->program->short}}</h2>
            <span class="chevron-right mx-1"></span>
            <a href="{{route('schemes.show', $slot->scheme)}}" class="flex items-center text-blue-600 link">
                {{$slot->scheme->subtitle()}}
                ({{$roman[$slot->semester_no-1]}})
            </a>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <h2 class="flex items-center mt-8">
            <div class="flex justify-center items-center w-7 h-7 bg-teal-100 rounded-full ring-1 ring-teal-200 ring-offset-2 mr-4"><i class="bi-plus-slash-minus text-[16px]"></i> </div>Add or Remove Course Types
        </h2>
        <div class="grid grid-cols-1 p-6 rounded-md border mt-4 text-slate-600">
            <div class="grid grid-cols-1 md:grid-cols-3  gap-y-4">
                @foreach($slot->slot_options as $slot_option)
                <div class="flex space-x-2 items-center awesome-chk">
                    <h2>{{$slot_option->course_type->name}}</h2>
                    <form action="{{route('slot-options.destroy',$slot_option)}}" method="POST" id='del_form{{$slot_option->id}}'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-0 text-xs" onclick="delme('{{$slot_option->id}}')"><i class="bi bi-x text-[16px]"></i></button>
                    </form>
                </div>
                @endforeach
            </div>
            <div class="border-b my-4"></div>

            <form action="{{route('slot-options.store')}}" method='post'>
                @csrf
                <input type="hidden" name="slot_id" value="{{$slot->id}}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-4">
                    @foreach($missing_course_types as $course_type)
                    <div class="flex space-x-2 items-center awesome-chk">
                        <input type="checkbox" id='chk-{{$course_type->id}}' name='course_type_id[]' value="{{$course_type->id}}" class="chk hidden">
                        <label for="chk-{{$course_type->id}}">
                            <!-- bullet from app.css -->
                            <span></span>
                        </label>
                        <div>{{$course_type->name}}</div>
                    </div>
                    @endforeach
                </div>

                <div class="flex mt-4">
                    <button type="submit" class="btn-blue rounded">Add Now</button>
                </div>

            </form>
        </div>

        <h2 class="flex items-center mt-8"><i class="bi-link-45deg text-[24px] mr-4"></i> Bind specific course with current slot (optional) </h2>
        <div class="grid grid-cols-2 p-6 gap-y-4 mt-4 rounded-lg border">
            <h3>Course Type</h3>
            <h3>Course</h3>
            @foreach($slot->slot_options as $slot_option)
            <div>{{$slot_option->course_type->name}}</div>
            <div>
                @if(!$slot_option->course)
                <a href="{{route('slot-options.edit', $slot_option)}}" class="flex items-center link"><i class="bi-link-45deg text-[24px]"></i> <span class="text-xs text-slate-600">(select course)</span></a>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{route('slot-options.edit', $slot_option)}}" class="link">{{$slot_option->course->name}}</a>
                    <form action="{{route('slot-options.update',$slot_option)}}" method="POST" class="">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="course_id" value="" class="hidden">
                        <button type="submit" class="">
                            <i class="bi-x"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
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