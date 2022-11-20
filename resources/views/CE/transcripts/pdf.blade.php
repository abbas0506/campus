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

<body>
    <div class="container">
        <div class="relative w-full">
            <div class="absolute left-0 z-5">
                <img alt="logo" src="{{public_path('/images/logo/logo-light.png')}}" class="w-36">
            </div>
            <div class="tracking-wider pl-40 text-4xl font-bold">University of Okara</div>

        </div>
        <div class="w-full text-center mt-4">
            <span class="border border-solid px-2 py-1">Transcript</span>
        </div>
        <table class="w-full mt-8">
            <tbody>
                <tr class="text-xs font-bold mt-8">
                    <td class="w-32 py-1">Program Name</td>
                    <td class="w-64 py-1">{{$student->section->program->name}}</td>
                    <td class="w-32 py-1">Session</td>
                    <td class="w-64 py-1">2022-24</td>
                </tr>
                <tr class="text-xs font-bold">
                    <td class="w-32 py-1">Candidate Name</td>
                    <td class="w-64 py-1">{{$student->name}}</td>
                    <td class="w-32 py-1">Roll No.</td>
                    <td class="w-64 py-1">{{$student->rollno}}</td>
                </tr>
                <tr class="text-xs font-bold">
                    <td class="w-32 py-1">Father Name:</td>
                    <td class="w-64 py-1">{{$student->section->program->name}}</td>
                    <td class="w-32 py-1">Registration No.:</td>
                    <td class="w-64 py-1">{{$student->regno}}</td>
                </tr>
            </tbody>
        </table>


        <table class="w-full mt-8">
            <thead>
                <tr class="w-full text-sm">
                    <th class="border border-solid pl-2">Course Code</th>
                    <th class="border border-solid pl-2">Course Title</th>
                    <th class="border border-solid text-center">Credit Hrs</th>
                    <th class="border border-solid text-center">Obtaied Marks out of 100</th>
                    <th class="border border-solid text-center ">Grade Point</th>
                    <th class="border border-solid text-center ">Grade Letter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semester_nos as $semester_no)
                <tr>
                    <td colspan="6">Semester-{{$semester_no}}</td>
                </tr>
                @foreach($results->where('semester_no',$semester_no) as $result)

                <tr class="text-xs">
                    <td class="py-1 pl-2 border border-solid border-gray-600 w-12">{{$result->course_allocation->course->code}}</td>
                    <td class="py-1 pl-2 border border-solid border-gray-600 w-64">{{$result->course_allocation->course->name}}</td>
                    <td class="py-1 text-center border border-solid border-gray-600">{{$result->creditHrs()}}</td>
                    <td class="py-1 text-center border border-solid border-gray-600 w-28">{{$result->obtained()}}</td>
                    <td class="py-1 text-center border border-solid border-gray-600">{{$result->gradePoint()}}</td>
                    <td class="py-1 text-center border border-solid border-gray-600">{{$result->gradeLetter()}}</td>
                </tr>
                @endforeach
                @endforeach
                <tr class="text-sm font-bold">
                    <td class="px-8 text-right border border-solid" colspan="2"> Total</td>
                    <td class="text-center border border-solid">
                        <div class="border-b">135</div>
                    </td>
                    <td class="border border-solid">
                        <div class="text-center border-b border-0 border-solid">135/200</div>
                        <div class="text-center">85%</div>
                    </td>
                    <td class="text-center border border-solid"></td>
                    <td class="text-center border border-solid"></td>
                </tr>
            </tbody>
        </table>
        <div class="w-full">
            <div class="w-full text-center text-xs mt-2">*Errors & Omissions are expected</div>
            <div class="text-sm mt-8">Date of Issue: _______________</div>
            <div class="text-sm mt-4 ml-8">Prepared By:</div>
            <div class="text-sm mt-4 ml-8">Checked By:</div>
            <div class="text-sm mt-4 ml-8">
                <span class="">Result Declaration Date: _______________</span>
                <span class="ml-48 font-bold">Controller of Examination</span>
            </div>

        </div>

    </div>
    </div>

</body>

</html>