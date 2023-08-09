@extends('layouts.hod')
@section('page-content')
<h1><a href="{{url('clases')}}"> Classes / Sections</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$section->title()}} / import
    </div>
</div>

<div class="container  mx-auto">

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form action="{{route('students.import')}}" method="POST" enctype="multipart/form-data" class="flex flex-col mt-8 w-full">
        @csrf

        <div class="flex flex-col border rounded-sm bg-gray-100 p-3">
            <label for="" class="">Please select an excel file</label>
            <input type="file" name='file' class="mt-3">

        </div>

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Import</button>
        </div>
    </form>


    <!-- guidelines -->
    <div class="collapsible">
        <div class="head border border-dashed border-blue-300 mt-8">
            <div class="flex items-center space-x-2">
                <i class="bx bxs-chevron-down bx-burst text-blue-600"></i>
                <h2 class=""><span class="text-blue-600">See important instructions before you upload data</span></h2>
            </div>
        </div>

        <div class="body bg-gradient-to-b from-slate-200 to-white">
            <div class="px-12 py-8">
                <ul class="list-disc list-inside w-full leading-relaxed text-sm">
                    <li>Format your excel file according to following instructions and then click on <u>Choose file</u> button</li>
                    <li class="font-semibold">How to format excel file?
                        <ul class="list-inline list-[lower-roman] ml-8 font-normal leading-relaxed">
                            <li><u>rollno</u> must be unique. If the student with same rollno has already been registered in any class, whole input will be rejected</li>
                            <li><u>regno</u> may be null i.e if not provided, will be acceptable</li>
                            <li><u>gender</u> must be in single letter: m, f or t (t for Transgender)</li>
                            <li>Preferably, put all data on sheet 1</li>
                            <li>Use first row for column names only </li>
                            <li>Avoid blank rows over top of or below first row</li>
                        </ul>
                    </li>


                </ul>
                <table class="table-auto w-full mt-8">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-center">rollno</th>
                            <th class='text-center'>regno</th>
                            <th>name</th>
                            <th>father</th>
                            <th>gender</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="tr">
                            <td class="text-center">ZOOL-112-23</td>
                            <td></td>
                            <td>Umair Abbas</td>
                            <td>Muhammad Abbas</td>
                            <td class="text-center">m</td>
                        </tr>
                        <tr class="tr">
                            <td class="text-center">ZOOL-113-23</td>
                            <td></td>
                            <td>Sajid Ali</td>
                            <td>Muhammad Aslam</td>
                            <td class="text-center">m</td>
                        </tr>
                        <tr class="tr">
                            <td class="text-center">ZOOL-113-23</td>
                            <td class="text-center">UO-2353-62382</td>
                            <td>Hadia</td>
                            <td>Ahmad Ali</td>
                            <td class="text-center">f</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>

@endsection