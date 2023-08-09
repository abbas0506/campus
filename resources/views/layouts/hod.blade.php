@extends('layouts.basic')

@section('header')
<x-hod.header></x-hod.header>
@endsection

@section('sidebar')
<x-hod.sidebar></x-hod.sidebar>
@endsection


@section('body')

<div class="responsive-body">
    @yield('page-content')
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