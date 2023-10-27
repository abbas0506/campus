@extends('layouts.coordinator')
@section('page-content')
<div class="container">
    <h2>Section Change</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('coordinator.students.index')}}">Student Profile</a>
        <div>/</div>
        <div>Move</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-8">

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg bg-slate-100">

            <h2>{{ $student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father }}</h2>
            <h3>{{ $student->rollno }}</h3>
            <label>{{$student->address}}</label>
        </div>

        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg mt-2">
            <label for="" class="text-xs">Current Section</label>
            <h2>{{$student->section->title()}}</h2>
        </div>

        <div class="flex flex-col border border-dashed p-4 text-sm rounded-lg mt-2">
            <label for="" class="font-bold text-red-600">Can Move To</label>
            @foreach($clases->active()->get() as $clas)
            <div class="grid grid-cols-1 md:grid-cols-2 w-full text-sm gap-4 border-b md:divide-x divide-slate-200 py-2">
                <div>
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="text-sm">{{$clas->title()}}</div>
                        <div class="flex items-center space-x-2">
                            <div class="text-xs text-slate-400">
                                <i class="bi bi-person"></i> ({{$clas->strength()}})
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:pl-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach($clas->sections as $section)

                        <form action="{{route('coordinator.movement.update', $student->id)}}" method='post' id='form{{$section->id}}'>
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name='section_id' value='{{$section->id}}'>
                            <button type="submit" class="btn-teal w-16 text-xs" onclick="confirm_submit('{{$section->id}}')">{{$section->name}} <span class="text-xs">({{$section->students->count()}})</span></button>
                        </form>
                        @endforeach
                    </div>
                </div>

            </div>

            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function confirm_submit(id) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Section change will occur!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#form' + id).submit();
            }
        });
    }
</script>
@endsection