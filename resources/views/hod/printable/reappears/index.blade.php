@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Students</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Students</div>
        <div>/</div>
        <div>Reappear</div>
    </div>

    <h2 class="text-red-600 mt-5 "> <i class="bi-person-fill-slash mr-2"></i>Re-appearing Students: {{ $students->count() }}</h2>
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
                    <th class="w-24">Course</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)

                <tr class="tr text-xs md:text-sm">
                    <td>{{ $student->rollno }}</td>
                    <td class="text-left">{{ $student->name }}</td>
                    <td>
                        @foreach($student->first_attempts as $firstAttempt)
                        @foreach($firstAttempt->reappears as $reappear)
                        <p>
                            {{ $reappear->course_allocation->course->name }}
                        </p>
                        @endforeach
                        @endforeach
                    </td>
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