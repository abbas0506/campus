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

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-row items-center gap-x-4 mt-12">
        <i class="bi-info-circle text-2xl pr-4"></i>
        <div class="flex-grow text-left sm:mt-0">
            <ul class="text-sm">
                <li>Click + button to add a scheme</li>
            </ul>
        </div>
    </div>

    <div class="text-sm  text-gray-500 mt-8">{{$programs->count()}} programs found </div>

    <div class="overflow-x-auto w-full mt-1">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-50">Program Name</th>
                    <th class="w-50">Scheme(s)</th>
                </tr>
            </thead>
            <tbody>

                @foreach($programs->sortBy('level') as $program)
                <tr class="tr">
                    <td class="text-left pl-4">{{$program->short}} </br><span class="text-xs">{{$program->name}}</span></td>
                    <td>
                        <div class="flex flex-shrink-0 items-center space-x-2 pl-4">
                            @foreach($program->schemes as $scheme)
                            <a href="{{route('hod.schemes.show', $scheme)}}" class="w-20 text-sm pallet-teal p-0">
                                {{$scheme->semester->title()}}
                            </a>
                            @endforeach
                            <a href="{{route('hod.schemes.append',$program)}}" class="w-8 text-sm pallet-teal p-0">
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