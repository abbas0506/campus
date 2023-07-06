@extends('layouts.basic')
@section('content')
<!-- header -->
<x-header></x-header>

<aside aria-label="Sidebar" id='sidebar'>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Admin</div>
    <div class="text-sm text-center text-gray-400">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('admin')}}" class="flex items-center p-2">
                    <i class="bi bi-grid"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{url('departments')}}" class="flex items-center p-2">
                    <i class="bi bi-pass"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Departments</span>
                </a>
            </li>
            <li>
                <a href="{{url('headships')}}" class="flex items-center p-2">
                    <i class="bi bi-person-gear"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Headships</span>
                </a>
            </li>
            <!-- <li>
                <a href="{{url('user-access')}}" class="flex items-center p-2">
                    <i class="bi bi-people"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">User Access</span>
                </a>
            </li>

            <li>
                <a href="{{url('semesters')}}" class="flex items-center p-2">
                    <i class="bi bi-gear"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Semesters</span>
                </a>
            </li>
            <li>
                <a href="{{url('coursetypes')}}" class="flex items-center p-2">
                    <i class="bi bi-diamond"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Course Types</span>
                </a>
            </li> -->

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
</script>
@endsection