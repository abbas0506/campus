@extends('layouts.hod')
@section('page-content')
<div class="flex">
    <a href="{{route('students.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>Student Profile</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <i class="bx bx-user-circle text-slate-600 bx-md"></i>
    <div class="text-xl text-orange-500 leading-relaxed">{{$student->name}} @if($student->gender=='m') s/o @else d/o @endif {{$student->father}}</div>
    <div class="text-sm text-slate-600">{{$student->section->title()}}</div>
</div>
<div class="flex flex-row space-x-8 mt-12 w-full">
    <div class="flex flex-col border border-dashed p-4 rounded-lg w-1/3">
        <div class="flex items-center">
            <div class="font-semibold w-24">Roll No:</div>
            <div>{{$student->rollno}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Reg No:</div>
            <div>{{$student->regno}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Gender:</div>
            <div>{{$student->gender}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">CNIC:</div>
            <div>{{$student->cnic}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Phone:</div>
            <div>{{$student->phone}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Email:</div>
            <div>{{$student->email}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Address:</div>
            <div>{{$student->address}}</div>
        </div>
    </div>
    <div class="flex flex-col flex-1 border border-dashed p-4">
        <div class="flex items-center">
            <div class="font-semibold w-24">Admission:</div>
            <div>{{$student->section->clas->semester->title()}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Program:</div>
            <div>{{$student->section->clas->program->name}}</div>
        </div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Class:</div>
            <div>{{$student->section->title()}}</div>
        </div>
        <div class="font-semibold underline underline-offset-4 mt-4 mb-2">Academic History</div>
        <div class="flex items-center">
            <div class="font-semibold w-24">Admission:</div>
            <div>{{$student->section->clas->semester->title()}}</div>
        </div>
    </div>
</div>


@endsection