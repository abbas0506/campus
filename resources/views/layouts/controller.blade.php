@extends('layouts.basic')
@section('content')
<!-- header -->
<x-header></x-header>
<div class="flex relative top-16 w-screen">
    <aside aria-label="Sidebar" id='sidebar'>
        <div class="mt-4 text-sm text-center text-gray-400">{{date('M d, Y')}}</div>
        <div class="mt-12">
            <ul class="space-y-2">
                <li>
                    <a href="{{url('ce-award')}}" class="flex items-center p-2">
                        <i class="bx bx-award text-lg"></i>
                        <span class="ml-3">Award List</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2">
                        <i class="bx bx-receipt text-lg"></i>
                        <span class="ml-3">Cumulative Sheet</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('ce-gazette')}}" class="flex items-center p-2">
                        <i class="bx bx-badge-check text-lg"></i>
                        <span class="ml-3">gazette</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('transcripts')}}" class="flex items-center p-2">
                        <i class="bx bxs-graduation text-lg"></i>
                        <span class="ml-3">Transcripts</span>
                    </a>
                </li>

            </ul>

        </div>
    </aside>


    <div class="w-full md:w-3/4 md:ml-auto p-5 md:mr-8 text-slate-600">
        @yield('page-content')
    </div>

</div>
<script type="module">
    $('#toggle-current-user-dropdown').click(function() {
        $("#current-user-dropdown").toggle();
    });
    $('#menu').click(function() {
        $("#sidebar").toggle();
    });
</script>
@endsection