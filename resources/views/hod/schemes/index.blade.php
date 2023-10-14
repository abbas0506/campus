@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Schemes</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Program & Schemes</div>
        <div>/</div>
        <div>All</div>

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
    <div class="flex flex-wrap items-center gap-2 mt-8 mb-1">
        <div class="text-sm  text-gray-500">{{$programs->count()}} records found <span class='text-xs text-slate-600 ml-4 bg-teal-100 px-2'>(S=Spring, F=Fall)</span></div>
        <div class="text-xs text-gray-500"><i class="bx bxs-hand-right text-indigo-600 mr-2"></i>Click on + icon to add new scheme</div>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-50">Program Name</th>
                    <th class="w-50">Scheme(s)</th>
                </tr>
            </thead>
            <tbody>

                @foreach($programs->sortBy('level') as $program)
                <tr class="tr even:slate-100">
                    <td class="text-left">{{$program->short}}</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            @foreach($program->schemes as $scheme)
                            <a href="{{route('hod.schemes.show', $scheme)}}" class="w-12 px-2 text-sm bg-teal-100 text-center hover:bg-teal-600 hover:text-white">
                                {{$scheme->subtitle()}}
                            </a>
                            @endforeach
                            <a href="{{route('hod.schemes.append',$program)}}" class="flex items-center justify-center border border-dashed border-slate-200 bg-teal-50 hover:bg-teal-600 hover:text-white text-teal-800  w-12">
                                <i class="bx bx-plus"></i>
                            </a>
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