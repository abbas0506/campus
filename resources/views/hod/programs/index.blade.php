@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Programs</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Programs</div>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap items-center justify-between mt-4">
        <div class="text-sm  text-gray-500 mt-8 mb-1">{{$programs->count()}} records found</div>
        <a href="{{route('programs.create')}}" class="btn-indigo">
            Add New
        </a>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed borderless w-full">
            <thead>
                <tr>
                    <th class="w-60 text-left">Program Name</th>
                    <th class="w-16">Level <br> <span class="text-xs text-slate-400 font-thin">(years)</span></th>
                    <th class="w-16">Duration <br><span class="text-xs text-slate-400 font-thin">(years)</span></th>
                    <th class="w-16">Cr. Hrs <br> <span class="text-xs text-slate-400 font-thin">(total)</span></th>
                    <th class="w-24">Scheme(s)</th>
                    <th class="w-32">Internal</th>
                    <th class="w-20">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($programs->sortBy('level') as $program)
                <tr class="tr">
                    <td>{{$program->short}}</td>
                    <td class="text-center">{{$program->level}}</td>
                    <td class="text-center">{{$program->min_t}}-{{$program->max_t}}</td>
                    <td class="text-center">{{$program->cr}}</td>

                    <td>
                        <div class="flex items-center justify-center space-x-2 text-sm">
                            @foreach($program->schemes as $scheme)
                            <div>[{{$scheme->subtitle()}}]</div>
                            @endforeach
                        </div>
                    </td>
                    <td>

                        @if($program->internal_id=='')
                        <a href="{{route('internals.edit',$program)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-indigo-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </a>
                        @else
                        <a href="{{route('internals.edit',$program)}}" class="hover:zoom-sm hover:text-blue-600">
                            {{$program->internal->name}}
                        </a>
                        @endif
                        </a>
                    </td>
                    <td>
                        <div class="flex justify-center items-center space-x-3">
                            <a href="{{route('programs.edit', $program)}}">
                                <i class="bi bi-pencil-square text-green-600"></i>
                            </a>
                            @role('super')
                            <form action="{{route('programs.destroy',$program)}}" method="POST" id='del_form{{$program->id}}'>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$program->id}}')">
                                    <i class="bi bi-trash3 text-red-600"></i>
                                </button>
                            </form>
                            @endrole

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
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