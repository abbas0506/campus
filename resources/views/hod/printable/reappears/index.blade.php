@extends('layouts.hod')
@section('page-content')

<div class="responsive-container">
    <h2>Students</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Students</div>
        <div>/</div>
        <div>Reappear</div>
    </div>

    <h2 class="text-red-600 mt-5 "> <i class="bi-person-fill-down mr-2"></i>Re-appearing Students: {{ $students->count() }}</h2>
    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-5">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <div class="overflow-x-auto mt-8">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-12">Sr</th>
                    <th class="w-36">Roll No</th>
                    <th class="w-36">Name</th>
                    <th class="w-48">Course</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr class="tr text-xs md:text-sm">
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $student->rollno }}</td>
                    <td class="text-left">{{ $student->name }}</td>
                    <td class="text-left">
                        @foreach($student->reappears->where('semester_id', session('semester_id')) as $reappear)
                        <p class="text-slate-800 font-semibold">{{ $reappear->course_allocation->course->code }} {{ $reappear->course_allocation->course->name }} <span class="text-slate-500">{{ $reappear->course_allocation->course->lblCr() }}</span></p>
                        <p>{{ $reappear->course_allocation->section->title() }}</p>
                        <p>{{ $reappear->course_allocation->teacher->name }}</p>
                        @if(!$loop->last)
                        <p>-----</p>
                        @endif
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