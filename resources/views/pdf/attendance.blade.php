<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <style>
        @page {
            margin: 150px 80px 80px 50px;
        }

        .header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 2cm;
            color: black;
            text-align: center;
            /* line-height: 1.0cm; */
        }

        .footer {
            position: fixed;
            bottom: 30px;
            left: 30px;
            right: 0px;
            background-color: white;
            height: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .data tr th,
        .data tr td {
            font-size: 10px;
            text-align: center;
            padding-bottom: 4px;
            border: 0.5px solid;
            line-height: 14px;
        }

        td.border-t {
            border-top: 0.5px solid;
        }
    </style>
</head>
@php
$roman = config('global.romans');
@endphp

<body>
    <header class="header">
        <div class="w-1/2 mx-auto">
            <div class="relative">
                <div class="absolute"><img alt="logo" src="{{public_path('/images/logo/logo-light.png')}}" class="w-32"></div>
            </div>
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="text-center text-xl font-bold">UNIVERSITY OF OKARA</td>
                    </tr>
                    <tr>
                        <td class="text-center text-m font-bold">@if($termId==1) Midterm @else Final Term @endif Attendance Sheet</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <footer class="footer">
        <table class="mt-8 w-full">
            <tbody>
                <tr class="text-xs text-center">
                    <td style="color:#777; font-size:10px">Sign & date</td>
                    <td style="color:#777; font-size:10px">Sign & date</td>
                    <td style="color:#777; font-size:10px">Sign & date</td>
                </tr>
                <tr class="text-xs text-center">
                    <td>__________________</td>
                    <td>__________________</td>
                    <td>__________________</td>
                </tr>
                <tr class="text-xs text-center">
                    <td class="font-bold "></td>
                    <td class="font-bold ">
                    </td>
                    <td class="font-bold "></td>
                </tr>
                <tr class="text-xs text-center">
                    <td>Teacher</td>
                    <td>Incharge, Internal Exams</td>
                    <td>Chairperson/HoD/Incharge </td>
                </tr>
                <tr>
                    <td colspan=3 class="pt-4" style="border-bottom:1px solid #888;border-bottom-style:dashed"></td>
                </tr>
                <tr class="text-xs text-center ">
                    <td colspan="3" style="color:#222;font-size:10px"></td>
                </tr>
            </tbody>
        </table>
    </footer>

    <main>
        <div class="container">
            <!-- table header -->
            @foreach($clas->sections as $section)
            @foreach($section->course_allocations as $course_allocation)

            @if($course_allocation->course_id!='')
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="font-bold text-xs">Department:</td>
                        <td class="text-xs">{{$clas->program->department->name}}</td>
                        <td class="font-bold text-xs">Session:</td>
                        <td class="text-xs">{{$clas->session()}}</td>

                    </tr>
                    <tr>
                        <td class="font-bold text-xs">Program:</td>
                        <td class="text-xs">{{$clas->program->name}}</td>
                        <td class="font-bold text-xs">Semester:</td>
                        <td class="text-xs">{{App\Models\Semester::find(session('semester_id'))->short()}}</td>
                        <td class="font-bold text-xs">Section:</td>
                        <td class="text-xs">{{$section->name}}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">{{$course_allocation->course->code}} {{$course_allocation->course->name}}</div>
            @php $i=1; @endphp
            @foreach($course_allocation->enrolled()->chunk(35) as $chunk)
            <table class="w-full mt-2 data">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th class="w-4">#</th>
                        <th class="w-32">Roll No.</th>
                        <th class="w-36">Student Name</th>

                        <th class='w-24'>Answer Sheet No</th>
                        <th class='w-24'>Signature</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($chunk as $student)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$student->rollno}}</td>
                        <td class="pl-1" style="text-align: left !important;">{{$student->name}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

            @if($i%35!=1)
            @break
            @endif
            <div class="page-break"></div>

            @endforeach
            <div class="text-xs py-2">
                Fresh:{{$course_allocation->first_attempts->count()}}, Reappear: {{$course_allocation->reappears->count()}}, Total: {{$course_allocation->strength()}} </td>
            </div>

            <div class="page-break"></div>
            @endif
            @endforeach
            <div class="page-break"></div>
            @endforeach
        </div>
    </main>
    <script type="text/php">
        if (isset($pdf) ) {
            $x = 310;
            $y = 20;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>

</html>