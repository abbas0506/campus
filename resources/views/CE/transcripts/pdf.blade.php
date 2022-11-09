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
            margin: 75px 25px;
        }
    </style>
</head>

<body>
    <h1>Transcript</h1>
    <table>
        <tbody>
            <tr>
                <td>Program Name</td>
                <td>{{$student->section->program->name}}</td>
                <td>Session</td>
                <td>2022-24</td>
            </tr>
        </tbody>
    </table>
    <div class="flex mt-8">
        <div class="flex w-1/6 py-2 text-gray-800 font-bold"></div>
        <div class="flex w-2/6 py-2"></div>
        <div class="flex w-1/6 py-2 text-gray-800 font-bold">Session</div>
        <div class="flex w-2/6 py-2"></div>
    </div>
    <div class="flex">
        <div class="flex w-1/6 py-2 text-gray-800 font-bold">Candidate Name</div>
        <div class="flex w-2/6 py-2">{{$student->name}}</div>
        <div class="flex w-1/6 py-2 text-gray-800 font-bold">Roll No.</div>
        <div class="flex w-2/6 py-2">{{$student->rollno}}</div>
    </div>
    <div class="flex">
        <div class="flex w-1/6 py-2 text-gray-800 font-bold">Father Name</div>
        <div class="flex w-2/6 py-2">{{$student->father}}</div>
        <div class="flex w-1/6 py-2 text-gray-800 font-bold">Registration No.</div>
        <div class="flex w-2/6 py-2">{{$student->regno}}</div>
    </div>

    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="bg-gray-200">
                <th class="border pl-2">Course Code</th>
                <th class="border pl-2">Course Title</th>
                <th class="text-center border">Credit Hrs</th>
                <th class="text-center border">Obtaied Marks out of 100</th>
                <th class="text-center border">Grade Point</th>
                <th class="text-center border">Grade Letter</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semester_nos as $semester_no)
            <tr>
                <td colspan="6">Semester-{{$semester_no}}</td>
            </tr>
            @foreach($results->where('semester_no',$semester_no) as $result)

            <tr class="tr">
                <td class="py-1 pl-2 border">{{$result->course_allocation->course->code}}</td>
                <td class="py-1 pl-2 border">{{$result->course_allocation->course->name}}</td>
                <td class="py-1 text-center border">{{$result->course_allocation->course->credit_hrs_theory+$result->course_allocation->course->credit_hrs_practical}}</td>
                <td class="py-1 text-center border">{{$result->assignment+$result->practical+$result->midterm+$result->summative}}</td>
                <td class="py-1 text-center border"></td>
                <td class="py-1 text-center border"></td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>