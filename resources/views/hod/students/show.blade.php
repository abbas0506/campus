@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Student Profile</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('students.index')}}">Students</a>
        <div>/</div>
        <div>View</div>
    </div>

    <div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-8">
        <i class="bi bi-person-circle text-slate-600 bx-md"></i>
        <div class="text-xl text-orange-500 leading-relaxed">{{$student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father}}</div>
        <div class="text-sm text-slate-600">{{$student->section->clas->short()}}</div>
    </div>

    <div class="flex items-center justify-center gap-x-6 gap-y-2 flex-wrap text-sm mt-4">
        <a href="{{route('hod.change_section.edit',$student)}}" class="link">Change Section</a>
        <a href="{{route('hod.struckoff.edit',$student)}}" class="link">Struck Off</a>
        <a href="" class="link">Freeze Semester</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
        <div class="relative flex flex-col border border-dashed p-4 text-sm rounded-lg">
            <div class="absolute top-2 right-2">
                <a href="{{route('students.edit',$student)}}" class='link'>
                    <i class="bi-pencil-square"></i>
                </a>
            </div>
            <div class="flex items-center">
                <h3 class="w-24">Name:</h3>
                <label>{{$student->name}}</label>
            </div>
            <div class="flex items-center">
                <h3 class="w-24">Father:</h3>
                <label>{{$student->father}}</label>
            </div>
            <div class="flex items-center">
                <h3 class="w-24">Gender:</h3>
                <label>{{$student->gender}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">DOB:</h3>
                <label>{{$student->dob}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">CNIC:</h3>
                <label>{{$student->cnic}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">Phone:</h3>
                <label>{{$student->phone}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">Email:</h3>
                <label>{{$student->email}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">Address:</h3>
                <label>{{$student->address}}</label>
            </div>
        </div>
        <div class="flex flex-col border border-dashed p-4">
            <div class="flex items-center mt-1">
                <h3 class="w-24">Roll No:</h3>
                <label>{{$student->rollno}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">Reg No:</h3>
                <label>{{$student->regno}}</label>
            </div>
            <div class="flex items-center">
                <h3 class="w-24">Program:</h3>
                <label>{{$student->section->clas->program->name}}</label>
            </div>
            <div class="flex items-center mt-1">
                <h3 class="w-24">Class:</h3>
                <label>{{$student->section->clas->short()}}</label>
            </div>
            <div class="font-semibold text-sm underline underline-offset-4 mt-4">Academic History</div>
            @php $roman = config('global.romans'); @endphp
            <div class="overflow-x-auto mt-4">
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-24">Semester</th>
                            <th class="w-36">Course</th>
                            <th class="w-16">Cr</th>
                            <th class="w-16">No</th>
                            <th class="w-24">Marks</th>
                            <th class="w-16">GPA</th>
                            <th class="w-16">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->first_attempts()->get() as $attempt)
                        <tr class="text-center">
                            <td>{{$attempt->semester->short()}}</td>
                            <td class="text-left">{{$attempt->course_allocation->course->name}}</td>
                            <td>{{$attempt->course_allocation->course->cr()}}</td>
                            <td>{{$roman[$student->section->clas->semesterNo($attempt->semester_id)-1]}}</td>
                            <td>{{$attempt->obtained()}}/100</td>
                            <td>{{$attempt->gpa()}}</td>
                            <td>{{$attempt->grade()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

@endsection