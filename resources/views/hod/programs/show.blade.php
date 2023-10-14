@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>{{$program->name}}</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.programs.index')}}">Programs</a>
        <div>/</div>
        <div>View</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
        <div class="flex items-center justify-between border border-dashed bg-white p-4">
            <div>
                <label for="" class="text-xs">Scheme(s)</label>

                @if($program->schemes()->exists())
                <div class="flex flex-wrap items-center">
                    @foreach($program->schemes as $scheme)
                    <!-- show scheme name -->
                    {{$scheme->semester->title()}}
                    <!-- show delete option if no class follows this scheme -->
                    @if(!$program->clases()->followingScheme($scheme->id)->exists())
                    <form action="{{route('hod.schemes.destroy',$scheme)}}" method="POST" id='del_form{{$scheme->id}}'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-0" onclick="delme('{{$scheme->id}}')">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                    @endif
                    &nbsp &nbsp
                    @endforeach
                </div>
                @else
                <div class="text-sm text-slate-600">(blank)</div>
                @endif
            </div>
            <div class="flex justify-center items-center bg-slate-200 flex-shrink-0 w-12 h-12 rounded-full">
                <a href="{{route('hod.programs.schemes.add',$program)}}">
                    <i class="bx bx-plus text-lg"></i>
                </a>
            </div>
        </div>

        <div class="relative border border-dashed bg-white p-4">
            <a href="{{route('hod.programs.internal',$program)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
            <label for="" class="text-xs">Allocated Internal</label>
            <div>{{$program->internal->name ?? ''}}</div>
        </div>
        <div class="md:col-span-2 relative border border-dashed bg-white p-4">
            <a href="{{route('hod.programs.edit',$program)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>

            <label class="text-xs">Program Name</label>
            <div class="mb-2">{{$program->name ?? ''}}</div>

            <label class="text-xs">Short Name</label>
            <div class="mb-2">{{$program->short ?? ''}}</div>

            <label class="text-xs">Level</label>
            <div class="mb-2">{{$program->level ?? ''}} years</div>

            <label class="text-xs">Max Credit Hours</label>
            <div class="mb-2">{{$program->cr ?? ''}} </div>

            <label class="text-xs">Duration</label>
            <div class="mb-2">{{$program->min_t ?? ''}}-{{$program->max_t ?? ''}} years</div>


        </div>
    </div>
</div>
@endsection
@section('script')
<script>
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