@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Student Profile</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.students.index')}}">Students</a>
        <div>/</div>
        <div>View</div>
    </div>

    <div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-8">
        <div class="text-xl text-orange-500 leading-relaxed">{{$student->name}} @if($student->gender=='M') s/o @else d/o @endif {{$student->father}}</div>
        <div class="text-sm text-slate-600">{{$student->section->title()}}</div>
    </div>

    <div class="flex flex-col items-center justify-center gap-x-6 gap-y-2 flex-wrap text-sm mt-4">
        <h2 class="font-semibold">
            Status:
            @if($student->statuses()->exists())
            <span class="text-red-600"> {{$student->statuses()->latest()->first()->status->name}}</span>
            @else
            Active
            @endif
        </h2>
        <div class="flex items-center space-x-4">
            @if($student->latest_status_id()==1)
            <a href="{{route('hod.students.move',$student)}}" class="link">Change Section</a>
            <a href="{{route('hod.students.struckoff',$student)}}" class="link">Struck Off</a>
            <a href="{{route('hod.students.freeze', $student)}}" class="link">Freeze Semester</a>
            @elseif($student->latest_status_id()==2)
            <a href="{{route('hod.students.readmit',$student)}}" class="link">Unfreeze</a>
            @elseif($student->latest_status_id()==3)
            <a href="{{route('hod.students.readmit',$student)}}" class="link">Readmit</a>
            @endif
        </div>
    </div>
    <!-- basic profile -->
    <div class="collapsible mt-6">
        <div class="head">
            <h2> <span class="bx bx-user mr-2"></span> Basic Profile</h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">
            <div class="relative flex flex-col p-4 text-sm w-full">
                @if($student->latest_status_id()==1)
                <div class="absolute top-2 right-2">
                    <a href="{{route('hod.students.edit',$student)}}" class='link'>
                        <i class="bi-pencil-square"></i>
                    </a>
                </div>
                @endif
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
        </div>
    </div>
    <!-- Current semester Courses -->
    <div class="collapsible mt-3">
        <div class="head">
            <h2><span class="bx bx-book mr-2"></span>Current Semester Courses</h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">
            <div class="p-4 rounded w-full">
                <!-- <h2 class="underline underline-offset-4">Semester ({{App\Models\Semester::find(session('semester_id'))->title()}})</h2> -->
                <div class="flex items-center">
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
                @if($student->latest_status_id()==1)
                <h2 class="mt-3">Enrolled Courses </h2>
                <div class="overflow-x-auto w-full mt-2">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="w-8">Sr</th>
                                <th class="w-48">Course</th>
                                <th class="w-48">Teacher</th>
                                <th class="16">Status</th>
                                <th class="24">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sr=1; @endphp
                            @foreach($student->first_attempts as $first_attempt)
                            <tr>
                                <td>{{$sr++}}</td>
                                <td>{{$first_attempt->course_allocation->course->name}}</td>
                                <td>{{$first_attempt->course_allocation->teacher->name ?? ''}}</td>
                                <td>@if($first_attempt->is_enrolled) active @else blocked @endif</td>
                                <td>
                                    @if($first_attempt->is_enrolled)
                                    <form action="{{route('hod.allow-deny-attempt.update', $first_attempt)}}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name='is_enrolled' value="0">
                                        <button type="submit" class="btn btn-red rounded text-xs p-1 w-16">Block</button>
                                    </form>
                                    @else
                                    <form action="{{route('hod.allow-deny-attempt.update', $first_attempt)}}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name='is_enrolled' value="1">
                                        <button type="submit" class="btn btn-teal rounded text-xs p-1 w-16">Allow</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="collapsible mt-3">
        <div class="head">
            <h2><span class="bx bx-time mr-2"></span> Academic History</h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">
            @php $roman = config('global.romans'); @endphp
            <div class="overflow-x-auto p-4 w-full">
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