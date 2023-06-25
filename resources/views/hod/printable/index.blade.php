@extends('layouts.hod')
@section('page-content')
<div class="flex flex-col justify-center items-center w-full h-full">
    <div class="flex flex-col items-center justify-center w-3/4">

        <h1 class="text-3xl text-blue-900">Print / Soft Copy</h1>
        <p class="text-center mt-4">Here you can print or get soft copy output of the results orginally entered by the resource persons / teachers of your departments only. </p>
        <div class="grid grid-cols-3 gap-5 mt-12">

            <a href="{{url('hod/award/step1')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-award text-2xl"></i>
                <div class="mt-2">Award Lists</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('hod/gazette/step1')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-book text-2xl"></i>
                <div class="mt-2">Gazette</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <!-- <a href="{{url('hod/cum/step1')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200"> -->
            <a href="#" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-map-pin text-2xl"></i>
                <i class="bx bx-map-pin text-2xl"></i>
                <div class="mt-2">Cumulative</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <!-- <a href="{{url('teachers')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-group text-2xl"></i>
                <div class="mt-2">Teachers</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a> -->

        </div>
    </div>


</div>

@endsection