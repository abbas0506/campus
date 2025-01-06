@extends('layouts.hod')
@section('page-content')

<div class="responsive-container">
    <h2>Students</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Students</div>
        <div>/</div>
        <div>Inactive</div>
    </div>

    <h2 class="text-red-600 mt-5 "> <i class="bi-person-fill-slash mr-2"></i>Inactive Students: {{$department->currentStudents()->inactive()->count()}}</h2>
    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-5">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="overflow-x-auto mt-8">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-48">Roll No</th>
                    <th class="w-48">Name</th>
                    <th class="w-24">Status</th>
                    <th class="w-40">Remarks</th>
                    <th class="w-24">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($department->currentStudents()->inactive()->get() as $student)
                <tr class="tr text-xs md:text-sm">
                    <td>{{ $student->rollno }}</td>
                    <td class="text-left">{{ $student->name }}</td>
                    <td>{{ $student->latestSuspension()->status->name }}</td>
                    <td>{{ $student->latestSuspension()->remarks }}</td>
                    <td>{{ $student->latestSuspension()->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
    @section('script')
    <script type="text/javascript">
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