@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Cumulative Preview</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('hod/printable')}}">Print Options</a>
        <div>/</div>
        <div>Cumulative</div>
        <div>/</div>
        <div>Preview</div>
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

    <div class="flex items-center flex-wrap justify-between">
        <div class="text-slate-400 text-sm mt-12 font-thin">{{$section->students->count()}} students found</div>
        <a href="" target="_blank" class="flex items-center btn-teal">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-orange-200 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Print
        </a>
    </div>

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