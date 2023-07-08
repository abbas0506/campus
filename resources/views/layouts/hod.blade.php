@extends('layouts.basic')
@section('content')
<header>
    <div class="flex w-full h-16 items-center justify-between">
        <div class="flex items-center py-1">
            <a href="{{url('hod')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="text-base md:text-xl font-semibold">Examination System</div>
            <div class="px-4">|</div>
            <div class="text-sm flex items-center space-x-2">
                <div>HoD {{Str::replace('Department of', '', session('department')->name)}}</div>
                <i class="bi bi-chevron-compact-right"></i>
                <!-- <a href="{{url('/')}}" class="text-blue-600 hover:text-blue-800 text-xs">Change</a> -->
                <form action="{{route('switch.semester')}}" method="post" id='switchSemesterForm'>
                    @csrf
                    <select name="semester_id" id="cboSemesterId" class="px-2 font-semibold">
                        @foreach(App\Models\Semester::active()->get() as $semester)
                        <option value="{{$semester->id}}" @selected($semester->id==session('semester')->id)>{{$semester->short()}}</option>
                        @endforeach
                    </select>
                </form>

            </div>
        </div>
        <!-- right sided current user info -->
        <div id="current-user-area" class="flex space-x-3 items-center justify-center relative mr-8">
            <input type="checkbox" id='toggle-current-user-dropdown' hidden>
            <label for="toggle-current-user-dropdown" class="hidden md:flex items-center">
                <div class="">{{auth()->user()->name}}</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mx-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </label>

            <div class="hidden md:flex rounded-full bg-indigo-300 text-indigo-800 p-2" id='current-user-avatar'>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <!-- <img src="{{asset('/images/logo/logo-light.png')}}" alt="" class="rounded-full w-10 h-10"> -->
            </div>

            <div class="current-user-dropdown text-sm" id='current-user-dropdown'>

                <a href="{{url('changepw')}}" class="flex items-center border-b py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 mr-3 -rotate-90">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    Change Password
                </a>
                <a href="{{url('signout')}}" class="flex items-center border-b py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Sign Out
                </a>
            </div>
            <span id='menu' class="flex md:hidden">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
            </span>
        </div>
    </div>

</header>
<aside aria-label="Sidebar" id='sidebar'>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">{{session('semester')->title()}}</div>
    <div class="text-xs text-center">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('hod')}}" class="flex items-center p-2">
                    <i class="bx bx-cog"></i>
                    <span class="ml-3">One Time Activity</span>
                </a>
            </li>
            <li>
                <a href="{{url('clases')}}" class="flex items-center p-2">
                    <i class="bx bx-male-female"></i>
                    <span class="ml-3">Classes / Sections</span>
                </a>
            </li>
            <li>
                <a href="{{url('students')}}" class="flex items-center p-2">
                    <i class="bi bi-person-circle"></i>
                    <span class="ml-3">Student Profile</span>
                </a>
            </li>
            <li>
                <a href="{{url('courseplan')}}" class="flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span class="ml-3">Course Allocation</span>
                </a>
            </li>
            <li>
                <a href="{{url('hod/printable')}}" class="flex items-center p-2">
                    <i class="bi bi-printer"></i>
                    <span class="ml-3">Print / Soft Copy</span>
                </a>
            </li>
            <li class="md:hidden">
                <hr>
            </li>
            <li class="md:hidden">
                <a href="{{url('departments')}}" class="flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    <span class="ml-3">My Profile</span>
                </a>
            </li>
            <li class="md:hidden">
                <a href="{{route('signout')}}" class="flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                    </svg>
                    <span class="ml-3">Logout</span>
                </a>
            </li>

        </ul>
    </div>
</aside>

<div class="content-page">
    <div class="offset-sidebar"></div>
    <div class="flex flex-col flex-1">
        <div class="offset-header"></div>
        <div class="flex flex-col flex-1 p-12 overflow-x-hidden">
            @yield('page-content')
        </div>
    </div>

</div>

<script type="module">
    $('#toggle-current-user-dropdown').click(function() {
        $("#current-user-dropdown").toggle();
    });
    $('#menu').click(function() {
        $("#sidebar").toggle();
    });
    $('#cboSemesterId').change(function() {
        $('#switchSemesterForm').submit();
    });
</script>
@endsection