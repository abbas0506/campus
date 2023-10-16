@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Print Gazette</h2>
    <div class="bread-crumb">
        <a href="{{route('hod.gazette.index')}}">Cancel & Go Back</a>
    </div>

    <div class="flex flex-wrap items-center justify-center space-x-4 mt-8 border border-dashed p-4">
        <h2 class='text-red-600'>{{$section->title()}} </h2>
        <a href="{{route('hod.gazette.pdf', $section)}}" target='_blank' class="btn-teal text-sm"><i class="bi-printer"></i></a>
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
        <i class="bi bi-search absolute top-2 right-2"></i>
    </div>
    <!-- section students -->
    <div class="overflow-x-auto w-full mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-12">Sr No</th>
                    <th class="w-36">Roll No</th>
                    <th class="w-32">Reg. No</th>
                    <th class="w-48 text-left">Student Name</th>
                    <th class="w-48 text-left">Father Name</th>
                    <th class="w-20">Total</th>
                    <th class="w-24">Status</th>
                    <th class="w-24">Remarks</th>
                    <th class="w-32">Failing Subject</th>
                </tr>
            </thead>
            <tbody>
                @php $sr=0;@endphp
                @foreach($section->students as $student)
                <tr class="tr text-xs">
                    <td>{{++$sr}}</td>
                    <td>{{$student->rollno}}</td>
                    <td>{{$student->regno}}</td>
                    <td class="text-left">{{$student->name}}</td>
                    <td class="text-left">{{$student->father}}</td>
                    <td>{{$student->overall_percentage()}} %</td>
                    <td>{{$student->cgpa()}}</td>
                    <td>{{$student->promotion_status()}}</td>
                    <td>{{$student->failed_courses()}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection