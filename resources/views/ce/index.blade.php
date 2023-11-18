@extends('layouts.controller')
@section('page-content')
<div class="container bg-slate-100 h-[90vh]">
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <h2>Controller Panel</h2>
            <div class="bread-crumb">
                <div>Home</div>
                <div>/</div>
                <div>Controller</div>
            </div>
        </div>
        <div class="text-slate-500">{{ today()->format('d/m/Y') }}</div>
    </div>

    <div class="flex flex-col bg-white justify-center items-center w-full py-16 mt-24">
        <div class="flex flex-col items-center justify-center w-3/4">

            <h1 class="text-2xl text-blue-900">Welcome to controller panel!</h1>
            <!-- <p class="text-center mt-4">Use sidebar options to </p> -->
        </div>
    </div>
</div>
@endsection