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
            margin: 50px 50px 220px 80px;
        }

        .footer {
            position: fixed;
            bottom: -70px;
            left: 30px;
            right: 0px;
            background-color: white;
            height: 50px;
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
                    <td class="font-bold ">{{$course_allocation->teacher->name}}</td>
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
                        <td class="text-xs">{{$course_allocation->scheme_detail->scheme->program->name}}</td>
                        <td class="font-bold text-xs">Semester:</td>
                        <td class="text-xs">{{$roman[$course_allocation->section->clas->semesterNo(session('semester')->id)-1]}}</td>
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

            <table class="w-full mt-2">
                <thead>
                    <tr class="border-b text-xs" style="background-color: #bbb;">
                        <th class="text-center border xs w-36">Roll No.</th>
                        <th class="border w-36">Student Name</th>

                        @if($course_allocation->section->clas->program->level==21)
                        <th class="text-center border w-12">Asgn etc. <br>20%</th>
                        @else
                        <th class="text-center border w-8">Assign <br>10%</th>
                        <th class="text-center border w-8">Pres<br>10%</th>
                        @endif
                        <th class='text-center border w-8'>Mid<br> 30%</th>
                        <th class='text-center border w-12'>Fmt.<br>50%</th>
                        <th class='text-center border w-12'>Smt.<br>50%</th>
                        <th class='text-center border w-12'>Total</th>
                        <th class='text-center border w-8'>GP</th>
                        <th class='text-center border w-8'>Grade</th>
                        <th class='text-center border w-8'>Rem.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                    <tr class="tr border-b text-xs">
                        <td class="text-center border">{{$first_attempt->student->rollno}}</td>
                        <td class="pl-1 border">{{$first_attempt->student->name}}</td>
                        <td class='text-center border'>{{$first_attempt->assignment}}</td>
                        <!-- dont show for phd -->
                        @if($course_allocation->section->clas->program->level!=21)
                        <td class='text-center border'>{{$first_attempt->presentation}}</td>
                        @endif
                        <td class='text-center border'>{{$first_attempt->midterm}}</td>
                        <td class='text-center border'>{{$first_attempt->formative()}}</td>
                        <td class='text-center border'>{{$first_attempt->summative}}</td>
                        <td class='text-center border' style="background-color: #ddd;">{{$first_attempt->total()}}</td>
                        <td class='text-center border'>{{$first_attempt->gpa()}}</td>
                        <td class='text-center border'>{{$first_attempt->grade()}}</td>
                        <td class='text-center border'>{{$first_attempt->status()}}</td>
                    </tr>
                    @endforeach

                    @if($course_allocation->reappears->count()>0)

                    <tr>
                        <td class="text-xs py-2">* Reappearing</td>
                    </tr>
                    @foreach($course_allocation->reappears_sorted() as $reappear)
                    <tr class="tr border-b text-xs">
                        <td class="text-center border">{{$reappear->first_attempt->student->rollno}}</td>
                        <td class="border pl-1">{{$reappear->first_attempt->student->name}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->assignment}}</td>
                        <!-- dont show for phd -->
                        @if($course_allocation->section->clas->program->level!=21)
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->presentation}}</td>
                        @endif
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->midterm}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->formative()}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->summative}}</td>
                        <td class='text-center border' style="background-color: #ddd;">{{$reappear->first_attempt->best_attempt()->total()}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->gpa()}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->grade()}}</td>
                        <td class='text-center border'>{{$reappear->first_attempt->best_attempt()->status()}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td class="text-xs py-2" colspan="11">Fresh:{{$course_allocation->first_attempts->count()}}, Reappear: {{$course_allocation->reappears->count()}}, Total: {{$course_allocation->strength()}} </td>
                    </tr>
                </tbody>
            </table>

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