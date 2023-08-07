@extends('layouts.hod')
@section('page-content')
<div class="flex">
    <a href="{{route('students.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>Back</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <i class="bi bi-person-circle text-slate-600 bx-md"></i>
    <div class="text-xl text-orange-500 leading-relaxed">{{$student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father}}</div>
    <div class="text-sm text-slate-600">{{$student->section->clas->short()}}</div>
</div>


<div class="flex flex-row space-x-8 mt-12 w-full">
    <a href="{{route('students.edit',$student)}}" class='link'>Edit Profile</a>
    <div class="flex flex-col border border-dashed p-4 rounded-lg w-1/3">
        <div class="flex items-center text-sm">
            <div class="font-semibold w-24">Roll No:</div>
            <div>{{$student->rollno}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Reg No:</div>
            <div>{{$student->regno}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Gender:</div>
            <div>{{$student->gender}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">CNIC:</div>
            <div>{{$student->cnic}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Phone:</div>
            <div>{{$student->phone}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Email:</div>
            <div>{{$student->email}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Address:</div>
            <div>{{$student->address}}</div>
        </div>
    </div>
    <div class="flex flex-col flex-1 border border-dashed p-4">
        <div class="flex items-center text-sm">
            <div class="font-semibold w-24 text-sm">Program:</div>
            <div>{{$student->section->clas->program->name}}</div>
        </div>
        <div class="flex items-center text-sm mt-1">
            <div class="font-semibold w-24">Class:</div>
            <div>{{$student->section->clas->short()}}</div>
        </div>
        <div class="font-semibold text-sm underline underline-offset-4 mt-4 mb-2">Academic History</div>
        @php $roman = config('global.romans'); @endphp
        <table class="table table-auto">
            <thead>
                <tr>
                    <th class="text-xs">Course</th>
                    <th class="text-xs">Cr</th>
                    <th class="text-xs">Semester</th>
                    <th class="text-xs">No</th>
                    <th class="text-xs">Obtained</th>
                    <th class="text-xs">GPA</th>
                    <th class="text-xs">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->first_attempts()->get() as $attempt)
                <tr>
                    <td class="text-xs">{{$attempt->course_allocation->course->name}}</td>
                    <td class="text-xs text-center">{{$attempt->course_allocation->course->cr()}}</td>
                    <td class="text-xs text-center">{{$attempt->semester->short()}}</td>
                    <td class="text-xs text-center">{{$roman[$student->section->clas->semesterNo($attempt->semester_id)-1]}}</td>
                    <td class="text-xs text-center">{{$attempt->obtained()}}/100</td>
                    <td class="text-xs text-center">{{$attempt->gpa()}}</td>
                    <td class="text-xs text-center">{{$attempt->grade()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>


@endsection