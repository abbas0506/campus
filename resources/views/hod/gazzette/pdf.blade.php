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
            margin: 80px 50px;
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
                <div class="absolute"><img alt="logo" src="{{public_path('/images/logo/logo-light.png')}}" class="w-32"></div>
            </div>
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="text-center text-lg font-bold">UNIVERSITY OF OKARA</td>
                    </tr>
                    <tr>
                        <td class="text-center text-base font-bold">Result Gazzette {{session('semester')}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full mt-4">
                <tbody>
                    <tr>
                        <td class="text-center text-sm font-bold">{{$section->clas->program->department->name}}</td>
                    </tr>
                    <tr>
                        <td class="text-center text-sm font-bold">{{$section->clas->program->name}}</td>
                    </tr>
                    <tr>
                        <td class="text-center text-sm font-bold">{{$section->clas->title()}}</td>
                    </tr>
                </tbody>
            </table>

        </div>

        <!-- section students -->
        <table class="table-auto w-full mt-1 text-xs">
            <thead class="border bg-gray-100">
                <tr>
                    <th rowspan="3" class="text-center border">Sr No</th>
                    <th rowspan="3" class="text-center border">Roll No</th>
                    <th rowspan="3" class="text-center border">Reg. No</th>
                    <th rowspan="3" class="text-center border">Student Name</th>
                    <th rowspan="3" class="text-center border">Father Name</th>
                    <th colspan="2" class="text-center border">Total</th>
                    <th rowspan="3" class="text-center border">Status</th>
                    <th rowspan="3" class="text-center border">Failing Subject</th>
                </tr>
                <tr>
                    <th colspan=2 class="border text-center">Cr. Hrs {{$section->credit_hrs()}}</th>
                </tr>
                <tr>
                    <th class="text-center border">Percentage of marks <br>obtained / {{$section->total_marks()}}</th>
                    <th class="text-center border">CGPA</th>
                </tr>

            </thead>
            <tbody>
                @php $sr=0;@endphp
                @foreach($section->students as $student)
                <tr class="tr ">
                    <td class="py-2 text-center border">{{++$sr}}</td>
                    <td class="py-2 text-center border">{{$student->rollno}}</td>
                    <td class="py-2 text-center border">{{$student->regno}}</td>
                    <td class="py-2 border pl-1">{{$student->name}}</td>
                    <td class="py-2 border pl-1">{{$student->father}}</td>
                    <td class="py-2 text-center border">{{$student->overall_percentage()}} %</td>
                    <td class="py-2 text-center border">{{$student->cgpa()}}</td>
                    <td class="py-2 text-center border">{{$student->promotion_status()}}</td>
                    <td class="py-2 border pl-1">{{$student->failed_subjects()}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-xs">*Errors and omissions accepted</div>
        <table class="mt-16 w-full">
            <tbody>
                <tr class="text-center">
                    <td>____________________</td>
                    <td>____________________</td>
                    <td>____________________</td>
                </tr>
                <tr class="text-center">
                    <td class="text-xs">Prepared by:</td>
                    <td class="text-xs">Admin Officer Exams</td>
                    <td class="text-xs">Addl Controller of Examination</td>
                </tr>
            </tbody>
        </table>

</body>

</html>