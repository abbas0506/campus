@extends('layouts.basic')
@section('body')
<!-- header -->
<header>
    <div class="flex flex-wrap w-full h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="{{url('controller')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>

            <div class="text-sm">Controller</div>

        </div>

        <!-- right sided current user info -->
        <div id="current-user-area" class="flex space-x-3 items-center justify-center relative mr-8">
            <div class="hidden md:flex items-center text-sm">{{auth()->user()->name}}</div>

            <a href="{{route('admin.notifications.index')}}" class="relative">
                <i class="bi-bell"></i>
                @if(Auth::user()->notifications_received()->unread()->count()>0)
                <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-orange-400"></div>
                @endif
            </a>

            <a href="{{url('signout/me')}}" class="hidden md:flex rounded-full bg-orange-100 text-orange-800 p-2">
                <i class="bx bx-power-off"></i>
            </a>

            <span id='menu' class="flex md:hidden">
                <i class="bx bx-menu"></i>
            </span>
        </div>
    </div>

</header>
<!-- sidebar -->
<aside aria-label="Sidebar" id='sidebar'>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Controller</div>
    <div class="text-sm text-center text-gray-400">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{route('ce.students.index')}}" class="flex items-center p-2">
                    <i class="bi bi-person-circle"></i>
                    <span class="ml-3">Student Profile</span>
                </a>
            </li>
            <li>
                <a href="{{url('ce/award/step1')}}" class="flex items-center p-2">
                    <i class="bi bi-award text-lg"></i>
                    <span class="ml-3">Award List</span>
                </a>
            </li>
            <li>
                <a href="{{url('ce/gazette/step1')}}" class="flex items-center p-2">
                    <i class="bi bi-journal-check text-lg"></i>
                    <span class="ml-3">Gazette</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2">
                    <i class="bi bi-file-earmark-medical text-lg"></i>
                    <span class="ml-3">Cumulative Sheet</span>
                </a>
            </li>



            <li>
                <!-- <a href="{{url('transcripts')}}" class="flex items-center p-2"> -->
                <a href="{{url('/ce/transcripts')}}" class="flex items-center p-2">
                    <i class="bi bi-mortarboard text-lg"></i>
                    <span class="ml-3">Transcripts</span>
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
            <!-- <div class="w-full md:w-3/4 md:ml-auto px-5 md:mr-8 text-slate-600"> -->
            @yield('page-content')
            <!-- </div> -->
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
</script>
@endsection