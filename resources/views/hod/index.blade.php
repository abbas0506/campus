@extends('layouts.hod')
@section('page-content')
<div class="flex flex-col justify-center items-center w-full h-full">
    <div class="flex flex-col items-center justify-center w-3/4">

        <div class="bg-red-200 p-4 rounded-lg mb-4 text-sm">
            <h2>Software Update Alert V4.0 (07.08.23) </h2>
            <p class="mt-2 leading-relaxed">Respected HOD, software is going through evolutionary phase, with only intention to make your life easier than ever before. Your co-operation in this regard will be a matter of relief for development team.</p>
            <p>Please note following ...</p>
            <ul class="list-disc pl-4">
                <li>Only current semester data is available. If any course allocation is found missing, it is only because of its inconsitency with currently adopted scheme pattern. You may re-allocate the course</li>
                <li>Award.pdf is temporarily not available for maintenance purpose. </li>
                <li>Your previous data is intact. In case of any unavoidable situation, it can be re-produced in .excel form</li>
                <li>In case of any inconvenience, feel free to contact @developer 03000373004. (*preferably through whatsapp message)</li>
            </ul>
        </div>
        <h1 class="text-3xl text-blue-900">One Time Activity</h1>
        <p class="text-center mt-4">These are configuration related activities that you need to do only for once and ripe the fruit for a long. This is a type of data that does not change for a long period of time!</p>
        <div class="grid grid-cols-4 gap-5 mt-12">

            <a href="{{url('programs')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-award text-2xl"></i>
                <div class="mt-2">Programs</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('courses')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-book text-2xl"></i>
                <div class="mt-2">Courses</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('schemes')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bx-map-pin text-2xl"></i>
                <div class="mt-2">Schemes</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('teachers')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bx bxs-group text-2xl"></i>
                <div class="mt-2">Teachers</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>

        </div>
    </div>


</div>


@endsection