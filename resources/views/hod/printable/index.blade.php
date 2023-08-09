@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Print / Download</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Print Options</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-24">
        <div class="flex flex-col md:flex-row md:items-center gap-x-2">
            <i class="bi bi-info-circle px-2 text-2xl"></i>
            <ul class="text-sm">
                <li>Here you can print or get soft copy output of the results orginally entered by the resource persons / teachers of your departments only.</li>
                <li></li>
            </ul>
        </div>

        <div class="grid  grid-cols-1 md:grid-cols-3 gap-5 mt-12">

            <a href="{{url('hod/award/step1')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi bi-award text-2xl"></i>
                <div class="mt-2">Award Lists</div>
            </a>
            <a href="{{url('hod/gazette/step1')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi-journal-check text-2xl" -></i>
                <div class="mt-2">Gazette</div>
            </a>
            <a href="{{url('hod/cum/step1')}}" class="text-center rounded-lg bg-sky-200 p-4">
                <i class="bi-clipboard-check text-2xl"></i>
                <div class="mt-2">Cumulative</div>
            </a>
        </div>

    </div>
</div>
@endsection