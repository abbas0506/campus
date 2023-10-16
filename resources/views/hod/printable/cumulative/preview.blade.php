@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Cumulative Preview</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.cumulative.index')}}">Cancel & Go Back</a>
    </div>

    <div class="flex flex-wrap items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-red-600'>{{$section->title()}} </h2>
        <a href="#" target='_blank' class="btn-teal text-sm"><i class="bi-printer"></i></a>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="text-slate-400 text-sm mt-8">{{$section->students->count()}} students found</div>
    <div class="overflow-x-auto">
        <table class="table-fixed text-xs w-full mt-4">
            <thead>
                <tr>
                    <th class="w-8">Sr</th>
                    <th class="w-32">Roll #</th>
                    <th class="w-48">Name</th>
                    @foreach($slot_nos as $slot_no)
                    <th class="w-16">Subject {{$slot_no}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $sr=1; @endphp
                @foreach($section->students as $student)
                <tr class="tr text-xs">
                    <td>{{$sr++}}</td>
                    <td>{{$student->rollno}}</td>
                    <td class="text-left">{{$student->name}}</td>
                    <!-- marks, gp, grade -->

                    @foreach($slot_nos as $slot_no)
                    @php $attempt=$student->first_attempts()->during(session('semester_id'))->slot($slot_no)->first(); @endphp
                    <td>
                        @if($attempt)
                        {{$attempt->obtained()}}
                        @endif
                    </td>
                    @endforeach

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection