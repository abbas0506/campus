@extends('layouts.basic')
@section('body')
<!-- header -->
<x-header></x-header>

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