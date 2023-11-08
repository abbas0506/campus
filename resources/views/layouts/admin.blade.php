@extends('layouts.basic')
@section('body')
<!-- header -->
<header>
    <div class="flex flex-wrap w-full h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="{{url('admin')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>

            <div class="text-sm">Admin</div>

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

<aside aria-label="Sidebar" id='sidebar'>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Admin</div>
    <div class="text-sm text-center text-gray-400">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('admin')}}" class="flex items-center p-2">
                    <i class="bi bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.semesters.index')}}" class="flex items-center p-2">
                    <i class="bi bi-layers"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Semesters</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.departments.index')}}" class="flex items-center p-2">
                    <i class="bi bi-pass"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Departments</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.user-access.index')}}" class="flex items-center p-2">
                    <i class="bi bi-person-gear"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">User Access</span>
                </a>
            </li>


            <li>
                <a href="{{route('admin.coursetypes.index')}}" class="flex items-center p-2">
                    <i class="bi bi-book"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Course Types</span>
                </a>
            </li>

        </ul>
    </div>
</aside>

<div class="responsive-body">
    @yield('page-content')
</div>

<script type="module">
    $('#menu').click(function() {
        $("#sidebar").toggle();
    });
</script>
@endsection