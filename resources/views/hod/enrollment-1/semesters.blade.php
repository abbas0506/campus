@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mt-12 mb-5 md:my-10">
            <h1 class="text-indigo-500 text-xl">Fresh Enrollment</h1>
        </div>
        <!-- serach field -->
        <div class="relative ml-0 md:ml-40">
            <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>

    <div class=" flex flex-row text-sm text-blue-800 bg-blue-100 p-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
        </svg>

        If you dont see a specific semester in following list, contact admin !
    </div>
    <table class="table-auto w-full mt-3">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Semester</th>
                <th class='text-center'>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($semesters->sortByDesc('id') as $semester)
            <tr class="tr border-b text-gray-600">
                <td class="py-2 text-slate-600">
                    <div>{{$semester->semester_type->name}} {{$semester->year}}</div>
                </td>
                <td class="py-2 text-center">
                    <a href="{{route('enrollments.show',$semester)}}" class="bg-green-300 hover:bg-green-400 rounded-full px-2 text-xs text-gray-900">Select</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

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