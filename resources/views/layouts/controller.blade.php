@extends('layouts.basic')
@section('body')
<!-- header -->
<header class="user-header">
    <div class="flex flex-wrap w-full items-center justify-between px-5 md:px-12">
        <div class="flex items-center">
            <a href="{{url('controller')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>

            <div class="text-sm">Controller</div>

        </div>

        <!-- right sided current user info -->
        <div id="current-user-area" class="flex space-x-3 items-center justify-end relative">
            <div class="hidden md:flex items-center text-sm">{{auth()->user()->name}}</div>

            <a href="{{route('admin.notifications.index')}}" class="relative">
                <i class="bi-bell"></i>
                @if(Auth::user()->notifications_received()->unread()->count()>0)
                <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-orange-400"></div>
                @endif
            </a>

            <a href="{{url('signout')}}" class="hidden md:flex rounded-full bg-orange-100 text-orange-800 p-2">
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
    <div class="flex items-center justify-center w-full mt-16">
        <a href="{{url('/')}}" class="">
            <img alt="logo" src="{{asset('images/logo/logo.png')}}" class="w-24">
        </a>
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Controller</div>
    <div class="text-sm text-center text-gray-400">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('controller')}}" class="flex items-center p-2">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{route('controller.students.index')}}" class="flex items-center p-2">
                    <i class="bi bi-search"></i>
                    <span class="ml-3">Search Student</span>
                </a>
            </li>
            <li>
                <a href="{{route('controller.printable.choose.class')}}" class="flex items-center p-2">
                    <i class="bi bi-printer"></i>
                    <span class="ml-3">Printable</span>
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
                <a href="{{url('controller/transcripts')}}" class="flex items-center p-2">
                    <i class="bi bi-mortarboard text-lg"></i>
                    <span class="ml-3">Transcripts</span>
                </a>
            </li>
            <li class="md:hidden border-t border-dashed border-slate border-slate-400">
                <a href="{{route('signout')}}" class="flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                    </svg>
                    <span class="ml-3">Log Off</span>
                </a>
            </li>

        </ul>

    </div>
</aside>


<div class="responsive-body">
    @yield('page-content')
</div>

@endsection