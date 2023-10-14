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
        <a href="{{route('hod.programs.create')}}" class="btn-indigo">
            Add New
        </a>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-48 text-left">Program Name</th>
                    <th class="w-16">Level <br> <span class="text-xs text-slate-400 font-thin">(years)</span></th>
                    <th class="w-16">Duration <br><span class="text-xs text-slate-400 font-thin">(years)</span></th>
                    <th class="w-16">Cr. Hrs <br> <span class="text-xs text-slate-400 font-thin">(total)</span></th>
                    <th class="w-24">Scheme(s)</th>
                    <th class="w-40">Internal</th>
                    <th class="w-16">Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programs->sortBy('level') as $program)
                <tr class="tr">
                    <td class="text-left">
                        <a href="{{route('hod.programs.show',$program)}}" class="link">{{$program->short}}</a>
                    </td>
                    <td>{{$program->level}}</td>
                    <td>{{$program->min_t}}-{{$program->max_t}}</td>
                    <td>{{$program->cr}}</td>

                    <td>
                        <div class="flex flex-wrap items-center justify-center space-x-2 text-sm">
                            @foreach($program->schemes as $scheme)
                            <div>{{$scheme->semester->title()}}</div>
                            @endforeach
                        </div>
                    </td>
                    <td>{{$program->internal->name ?? ''}}</td>
                    <td>
                        @role('super')
                        <form action="{{route('hod.programs.destroy',$program)}}" method="POST" id='del_form{{$program->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$program->id}}')">
                                <i class="bi bi-trash3 text-red-600"></i>
                            </button>
                        </form>
                        @endrole
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