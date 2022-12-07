@extends('layouts.basic')
@section('content')
<!-- header -->
<x-header></x-header>
<div class="flex relative top-16 w-screen">
    <aside aria-label="Sidebar" id='sidebar' class="px-3">
        <div class="mt-4 text-sm text-center">{{date('d/m/Y')}}</div>
        <div class="mt-12">
            <ul class="space-y-2">
                <!-- <li>
                    <a href="{{url('teacher')}}" class="flex items-center p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li> -->

                <li>
                    <a href="{{route('mycourses.index')}}" class="flex items-center p-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span class="ml-3">My Courses</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="w-full md:w-3/4 md:ml-auto px-5 md:mr-8 text-slate-600">
        <div class="bg-gray-200 text-slate-600 text-center text-xs rounded-b-lg">Current Login: {{session('semester')}}, {{session('department')->name}} </div>
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