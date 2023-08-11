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
            margin: 50px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
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

        }
    </style>
</head>
@php
$roman = config('global.romans');
@endphp

<body>
    <footer class="footer">
        <table class="mt-8 w-full">
            <tbody>
                <tr class="text-xs text-center">
                    <td style="color:#777; font-size:10px">Sign & stamp with date</td>
                    <td style="color:#777; font-size:10px">Sign & stamp with date</td>
                    <td style="color:#777; font-size:10px">Sign & stamp with date</td>
                </tr>
                <tr class="text-xs text-center">
                    <td>__________________</td>
                    <td>__________________</td>
                    <td>__________________</td>
                </tr>
                <tr class="text-xs text-center">
                    <td class="font-bold ">{{$course_allocation->teacher->name ?? ''}}</td>
                    <td class="font-bold ">@if($course_allocation->internal()!='')
                        {{$course_allocation->internal()->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td class="font-bold ">{{$course_allocation->hod()->name}}</td>
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
                    <td colspan="3" style="color:#222;font-size:10px">{{$course_allocation->section->title()}}, {{$course_allocation->course->name}} ({{$course_allocation->course->code}})</td>
                </tr>
            </tbody>
        </table>
    </footer>

    <main>
        <div class="container">

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
                            <td class="text-center text-m font-bold">Assessment Sheet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- table header -->
            <table class="mt-8 w-full">
                <tbody>
                    <tr>
                        <td class="font-bold text-xs">Department:</td>
                        <td class="text-xs">{{$course_allocation->section->clas->program->department->name}}</td>
                        <td class="font-bold text-xs">Session:</td>
                        <td class="text-xs">{{$course_allocation->section->clas->session()}}</td>

                    </tr>
                    <tr>
                        <td class="font-bold text-xs">Program:</td>
                        <td class="text-xs">{{$course_allocation->section->clas->program->name}}</td>
                        <td class="font-bold text-xs">Semester:</td>
                        <td class="text-xs">{{$roman[$course_allocation->section->clas->semesterNo($course_allocation->semester_id)-1]}}</td>
                        <td class="font-bold text-xs">Section:</td>
                        <td class="text-xs">{{$course_allocation->section->name}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold text-xs">Course:</td>
                        <td class="text-xs">{{$course_allocation->course->name}}</td>
                        <td class="font-bold text-xs">Code:</td>
                        <td class="text-xs">{{$course_allocation->course->code}}</td>
                        <td class="font-bold text-xs">Cr. Hrs:</td>
                        <td class="text-xs">{{$course_allocation->course->creditHrs()}}({{$course_allocation->course->cr_theory}}-{{$course_allocation->course->cr_practical}})</td>
                    </tr>
                </tbody>
            </table>
            @php $i=1; @endphp
            @foreach($course_allocation->first_attempts_sorted()->chunk(30) as $chunk)
            <table class="w-full mt-2 data">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th class="w-4">#</th>
                        <th class="w-32">Roll No.</th>
                        <th class="w-36">Student Name</th>

                        @if($course_allocation->section->clas->program->level==21)
                        <th class="w-12">Asgn etc. <br>20%</th>
                        @else
                        <th class="w-8">Assign <br>10%</th>
                        <th class="w-8">Pres<br>10%</th>
                        @endif
                        <th class='w-8'>Mid<br> 30%</th>
                        <th class='w-10'>Fmt.<br>50%</th>
                        <th class='w-10'>Smt.<br>50%</th>
                        <th class='w-10'>Total</th>
                        <th class='w-8'>GP</th>
                        <th class='w-8'>Grade</th>
                        <th class='w-8'>Rem.</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($chunk as $first_attempt)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$first_attempt->student->rollno}}</td>
                        <td class="pl-1" style="text-align: left !important;">{{$first_attempt->student->name}}</td>
                        <td>{{$first_attempt->assignment}}</td>
                        <!-- dont show for phd -->
                        @if($course_allocation->section->clas->program->level!=21)
                        <td>{{$first_attempt->presentation}}</td>
                        @endif
                        <td>{{$first_attempt->midterm}}</td>
                        <td>{{$first_attempt->formative()}}</td>
                        <td>{{$first_attempt->summative}}</td>
                        <td style="background-color: #ddd;">{{$first_attempt->total()}}</td>
                        <td>{{$first_attempt->gpa()}}</td>
                        <td>{{$first_attempt->grade()}}</td>
                        <td>{{$first_attempt->status()}}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach

                </tbody>
            </table>
            <div class="text-xs py-2">
                Fresh:{{$course_allocation->first_attempts->count()}}, Reappear: {{$course_allocation->reappears->count()}}, Total: {{$course_allocation->strength()}} </td>
            </div>
            @if($i%30!=1)
            @break
            @endif
            <div class="page-break"></div>

            @endforeach

            <!-- <div class="page-break"></div> -->
            @if($course_allocation->reappears->count()>0)

            <div class="text-xs py-2">* Reappearing</div>

            <table class="w-full mt-2 data">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th class="w-32">Roll No.</th>
                        <th class="w-36">Student Name</th>
                        <th class="w-12">Asgn etc. <br>20%</th>
                        <th class="w-8">Pres<br>10%</th>
                        <th class='w-8'>Mid<br> 30%</th>
                        <th class='w-12'>Fmt.<br>50%</th>
                        <th class='w-12'>Smt.<br>50%</th>
                        <th class='w-12'>Total</th>
                        <th class='w-8'>GP</th>
                        <th class='w-8'>Grade</th>
                        <th class='w-8'>Rem.</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($course_allocation->reappears_sorted() as $reappear)
                    <tr>
                        <td>{{$reappear->first_attempt->student->rollno}}</td>
                        <td class="pl-1" style="text-align: left !important;">{{$reappear->first_attempt->student->name}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->assignment}}</td>
                        <!-- dont show for phd -->
                        @if($course_allocation->section->clas->program->level!=21)
                        <td>{{$reappear->first_attempt->best_attempt()->presentation}}</td>
                        @endif
                        <td>{{$reappear->first_attempt->best_attempt()->midterm}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->formative()}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->summative}}</td>
                        <td style="background-color: #ddd;">{{$reappear->first_attempt->best_attempt()->total()}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->gpa()}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->grade()}}</td>
                        <td>{{$reappear->first_attempt->best_attempt()->status()}}</td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
            @endif
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