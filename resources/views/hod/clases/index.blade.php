@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Classes & Sections</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Classes & Sections</div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center gap-x-2 mt-8">
        <i class="bi bi-info-circle mr-4"></i>
        <ul class="text-sm text-slate-600">
            <li>Class delete option will be available only if if it has overall no student (i.e. empty class)</li>
            <li>Class edit option will be availble only if its sections have not mande any course allocation </li>
        </ul>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <!-- records found -->
    <div class="text-xs font-thin text-slate-600 mt-8 mb-1">{{$programs->count()}} programs found</div>
    <!-- classes & section detail -->
    <div class="flex flex-col accordion">
        @foreach($programs->sortBy('level') as $program)
        <div class="collapsible">
            <div class="head">
                <h2 class="flex items-center space-x-4">
                    {{$program->short}}
                    <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->active()->count()}}</span>
                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <!-- collapsible body -->
            <div class="body">
                @foreach($program->clases()->active()->get() as $clas)
                <div class="grid grid-cols-1 md:grid-cols-2 w-full text-sm gap-4 border-b md:divide-x divide-slate-200 p-2">
                    <div>
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="text-sm">{{$clas->title()}}</div>
                            <div class="flex items-center space-x-2">
                                <div class="text-xs text-slate-400">
                                    <i class="bi bi-person"></i> ({{$clas->students()->count()}})
                                </div>
                                @if(Auth::user()->hasRole('super')||!$clas->course_allocations()->exists())
                                <a href="{{route('hod.clases.edit', $clas)}}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endif
                                @if(Auth::user()->hasRole('super')||!$clas->students()->exists())
                                <form action="{{route('hod.clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}'>
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800" onclick="delme('{{$clas->id}}')" @disabled($clas->strength()>0)>
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="md:pl-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach($clas->sections as $section)
                            <a href="{{route('hod.sections.show',$section)}}" class='pallet-teal'>
                                {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                            </a>
                            @endforeach
                            <form action="{{route('hod.sections.store')}}" method="post" class='pallet-teal'>
                                @csrf
                                <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                                <button type='submit'>
                                    <i class="bi bi-plus font-bold"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                @endforeach
                <div class="w-full mt-2">
                    @if($program->schemes->count()>0)
                    <a href="{{route('hod.clases.add',$program)}}" class="btn-teal float-left">
                        <i class="bi bi-plus"></i>
                        Add New Class
                    </a>
                    @else
                    <a href="{{route('hod.schemes.append',$program)}}" class="btn-teal float-left">
                        <i class="bi bi-plus"></i>
                        Define Scheme
                    </a>
                    @endif

                </div>

            </div>
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
            text: "It will be highly destructive!",
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