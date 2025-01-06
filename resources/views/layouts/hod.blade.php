@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('sidebar')
<x-sidebars.hod></x-sidebars.hod>
@endsection


@section('body')

<div class="responsive-body">
    @yield('page-content')
</div>

<script type="module">
    $('#toggle-current-user-dropdown').click(function() {
        $("#current-user-dropdown").toggle();
    });
    $('#cboSemesterId').change(function() {
        $('#switchSemesterForm').submit();
    });
</script>
@endsection