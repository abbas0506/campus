@extends('layouts.teacher')
@section('page-content')
<div class="container">
    <h2>Summarized Result</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('mycourses.index')}}">My Courses</a>
        <div>/</div>
        <div>Result</div>
    </div>
    <div class="flex flex-col md:items-center md:flex-row gap-y-4 mt-8">
        <div class="flex-1">
            <h1 class="text-red-600">{{$course_allocation->course->name}}</h1>
            <div class="text-sm">{{$course_allocation->section->title()}}</div>
        </div>
        <div class="md:w-60">
            <a href="{{route('assessment.show', $course_allocation)}}" class="pallet-box border">
                <div class="flex-1">
                    <div class="title">Submit Now</div>
                    <h2>0%</h2>
                </div>
                <div class="ico ml-8 bg-blue-100">
                    <i class="bi-check-lg text-blue-600 text-2xl"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="flex flex-wrap items-center space-x-8 mt-4">
        <div class="flex items-center space-x-2">
            <h2>Fresh:</h2>
            <p>{{$course_allocation->first_attempts->count()}}</p>
        </div>
        <div class="flex items-center space-x-2">
            <h2>Reappear:</h2>
            <p>{{$course_allocation->reappears->count()}}</p>
        </div>
        <div class="flex items-center space-x-2">
            <h2>Total:</h2>
            <p>{{$course_allocation->first_attempts->count()+$course_allocation->reappears->count()}}</p>
        </div>
        <div class="flex items-center space-x-2">
            <h2>Pass Ratio:</h2>
            <p>%</p>
        </div>

    </div>
    <div class="mt-2">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="overflow-x-auto w-full">
            <table class="table-fixed w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="w-24">Assessment</th>
                        <th class="w-16">Avg</th>
                        <th class="w-8">A</th>
                        <th class="w-8">B</th>
                        <th class="w-8">C</th>
                        <th class="w-8">D</th>
                        <th class="w-8">E</th>
                        <th class="w-8">F</th>
                        <th class="w-12">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Formative</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <a href="{{route('formative.edit', $course_allocation)}}"><i class="bi-pencil-square"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Summative</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <a href="{{route('summative.edit', $course_allocation)}}"><i class="bi-pencil-square"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    @endsection