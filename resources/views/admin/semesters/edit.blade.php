@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Lock/Unlock Semesters</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <div>Semester Control</div>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif


    <div class="flex flex-col mx-auto md:w-3/4 mt-12">
        <p><i class="bi bi-gear mr-2"></i><span class="text-lg font-semibold">{{$semester->short()}}</span> <span class="ml-4 text-sm">({{$semester->title()}})</span></p>
        <hr class="my-3">

        <div class="flex justify-between items-center">
            <div class="flex items-center w-full">
                <label class="mr-2">Current Status:</label>
                <div class="flex flex-1 justify-between items-center">

                    @if($semester->status==1)
                    <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                    <form action="{{route('admin.semesters.update', $semester)}}" method='post'>
                        @csrf
                        @method('PATCH')
                        <button type="submmit" class="btn-red">Lock Semester</button>
                    </form>
                    @else
                    <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                    <form action="{{route('admin.semesters.update', $semester)}}" method='post'>
                        @csrf
                        @method('PATCH')
                        <button type="submmit" class="btn-teal">Unlock Semester</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection