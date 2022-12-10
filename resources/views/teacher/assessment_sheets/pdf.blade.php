<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <style>
        @page {
            margin: 50px 50px;
        }
    </style>
</head>
@php
$roman = config('global.romans');
@endphp

<body>
    <div class="container">

        <div class="w-1/2 mx-auto">
            <div class="relative">
                <div class="absolute left-40"><img alt="logo" src="{{public_path('/images/logo/logo-light.png')}}" class="w-32"></div>
            </div>
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="text-center text-3xl font-bold">University of Okara</td>
                    </tr>
                    <tr>
                        <td class="text-center text-xl font-bold">Assessment / Result Sheet</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <table class="mt-16 w-full">
            <tbody>
                <tr>
                    <td class="font-bold">Program Name:</td>
                    <td>{{$course_allocation->scheme_detail->scheme->program->name}}</td>
                    <td class="font-bold">Semester:</td>
                    <td>{{$roman[$course_allocation->semester_no]}}</td>
                    <td class="font-bold">Session:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="font-bold">Course Title:</td>
                    <td>{{$course_allocation->course->name}}</td>
                    <td class="font-bold">Course Code:</td>
                    <td>{{$course_allocation->course->code}}</td>
                    <td class="font-bold">Credit Hours:</td>
                    <td>{{$course_allocation->course->creditHrs()}}</td>
                </tr>
            </tbody>
        </table>

        <table class="w-full mt-2">
            <thead>
                <tr class="border-b text-sm">
                    <th class="text-center border">Roll No.</th>
                    <th class="border">Student Name</th>
                    <th class="text-center border">Assignment <br> 10%</th>
                    <th class="text-center border">Presentation <br> 10%</th>
                    <!-- <th class='text-center border'>Attendance<br> 2%</th> -->
                    <th class='text-center border'>Midterm<br> 30%</th>
                    <th class='text-center border'>Formative<br>50%</th>
                    <th class='text-center border'>Summative<br>50%</th>
                    <th class='text-center border'>Marks <br> Obtained</th>
                    <th class='text-center border'>Grade <br>Point</th>
                    <th class='text-center border'>Grade<br> Letter</th>
                    <th class='text-center border'>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->first_attempts as $first_attempt)
                <tr class="tr border-b text-sm">
                    <td class="text-center border">{{$first_attempt->student->rollno}}</td>
                    <td class="border pl-1">{{$first_attempt->student->name}}</td>
                    <td class='text-center border'>{{$first_attempt->assignment}}</td>
                    <td class='text-center border'>{{$first_attempt->presentation}}</td>
                    <td class='text-center border'>{{$first_attempt->midterm}}</td>
                    <td class='text-center border'>{{$first_attempt->formative()}}</td>
                    <td class='text-center border'>{{$first_attempt->summative}}</td>
                    <td class='text-center border'>{{$first_attempt->summative()}}</td>
                    <td class='text-center border'>{{$first_attempt->gpa()}}</td>
                    <td class='text-center border'>{{$first_attempt->grade()}}</td>
                    <td class='text-center border'>{{$first_attempt->status()}}</td>
                </tr>
                @endforeach
                @foreach($course_allocation->reappears as $reappear)
                <tr class="tr border-b text-sm">
                    <td class="text-center border">{{$reappear->first_attempt->student->rollno}}</td>
                    <td class="border pl-1">{{$reappear->first_attempt->student->name}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->assignment}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->presentation}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->midterm}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->formative()}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->summative}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->summative()}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->gpa()}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->grade()}}</td>
                    <td class='text-center border'>{{$reappear->first_attempt->status()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="mt-4 w-full">
            <tbody>
                <tr>
                    <td class="font-bold py-4">Teacher Name:</td>
                    <td>{{Auth::user()->name}}</td>
                    <td class="font-bold">Signature:</td>
                    <td>________________________</td>
                    <td class="font-bold">Date:</td>
                    <td>________________________</td>
                </tr>

                <tr>
                    <td class="font-bold py-4">Incharge Internal Examination:</td>
                    <td>________________________</td>
                    <td class="font-bold">Signature:</td>
                    <td>________________________</td>
                    <td class="font-bold">Date:</td>
                    <td>________________________</td>
                </tr>

                <tr>
                    <td class="font-bold py-4">HoD / Chairperson:</td>
                    <td>{{$course_allocation->course->department->headship->user->name}}</td>
                    <td class="font-bold">Signature:</td>
                    <td>________________________</td>
                    <td class="font-bold">Date:</td>
                    <td>________________________</td>
                </tr>

            </tbody>
        </table>

</body>

</html>