@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mt-12 mb-5 md:my-10">
            <h1 class="text-indigo-500 text-xl">Enrollment</h1>
        </div>
        <!-- serach field -->
        <div class="relative ml-0 md:ml-40">
            <input type="text" id='search_input' placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <div class="flex flex-row items-center md:w-1/4 ml-4">

            <label for="" class="py-2 text-sm text-gray-400 ml-4">Duration</label>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 icon-gray ml-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <select id="duration" name="" class="input-indigo p-1 ml-4" onchange="search(event)">
                <option value="">All</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>
    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif

    <div class="flex text-xl items-center text-teal-700">
        {{session('semester')->semester_type->name}} {{session('semester')->year}}

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
        </svg>
    </div>
    <table class="table-auto w-full mt-10">
        <thead>
            <tr class="border-b border-slate-200">
                <th class="py-2 text-gray-600 text-left">Program</th>
                <th class="py-2 text-gray-600 text-left">Duration</th>
                <th class="py-2 text-gray-600 text-center">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach($programs->sortByDesc('id') as $program)
            <tr class="tr border-b text-slate-600">
                <td class="py-2">
                    <div>{{$program->name}}</div>
                    <div class="text-sm text-gray-500">{{$program->short}}</div>
                    <div class="text-sm text-gray-500">{{$program->code}}</div>
                </td>
                <td hidden>{{$program->duration}}</td>
                <td class="py-2">
                    <div class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-1 text-sm">{{$program->duration}} years</span>
                    </div>

                </td>

                <td class="p-2 text-center">
                    <a href="{{route('enrollments.edit', $program)}}" class="bg-green-300 hover:bg-green-400 rounded-full px-2 text-xs">Select</a>
                    <!-- <div class="flex flex-row items-center">
                        <span class="bg-indigo-100 text-indigo-500 w-5 h-5 mr-2 rounded-full inline-flex items-center justify-center"></span>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-orange-400 mr-2">
                            <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" />
                        </svg>
                        {{$program->students->where('shift','M')->count()}}
                        <a href="{{route('program-shifts.show', 'M')}}" class="bg-red-200 hover:bg-red-300 rounded-full px-2 text-xs ml-2">Show</a>
                        <span class="text-orange-400 px-3">|</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-slate-400 mr-2">
                            <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd" />
                        </svg>
                        {{$program->students->where('shift','E')->count()}}
                        <a href="{{route('department-sessions.show',$program)}}" class="bg-green-200 hover:bg-green-300 rounded-full px-2 text-xs ml-2">Show</a>

                    </div> -->


                </td>


            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = $('#search_input').val();
        var duration = $('#duration').val();

        if (duration === '') {
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        } else if (searchtext === '') {
            $('.tr').each(function() {
                if (!(
                        ($(this).children().eq(1).prop('outerText').toLowerCase() === duration)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        } else {

            $('.tr').each(function() {
                if (!($(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) &&
                        ($(this).children().eq(1).prop('outerText').toLowerCase() === duration)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

    }
</script>

@endsection