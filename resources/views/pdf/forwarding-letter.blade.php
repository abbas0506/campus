<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forwarding Letters</title>
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

        table.bordered tr td {
            border: 0.5px solid;
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
                <div class="absolute"><img alt="logo" src="{{public_path('/images/logo/logo-light.png')}}" class="w-48"></div>
            </div>
            <table class="w-full">
                <tbody>

                    <tr>
                        <td class="text-center text-xl font-bold">{{ strtoupper($clas->program->department->name) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center text-xl font-bold">UNIVERSITY OF OKARA</td>
                    </tr>
                    <tr>
                        <td class="text-center text-m pt-6">Proforma for Result Submission ({{ $clas->session() }})</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>

    <main>
        <div class="container">
            <!-- table header -->
            @foreach($clas->sections as $section)

            <table class="w-full bordered mt-16">
                <thead>
                    <tr>
                        <td class="text-center py-3" rowspan="2">Class</td>
                        <td class="text-center" rowspan="2">Sr</td>
                        <td class="text-center" rowspan="2">Course Title</td>
                        <td class="text-center" rowspan="2">Crdit Hrs</td>
                        <td class="text-center" rowspan="2">Course Code</td>
                        <td class="text-center" rowspan="2">Teacher Name</td>
                        <td class="text-center" colspan="3">Result Submission</td>

                    </tr>
                    <tr>
                        <td class="text-center">Soft Copy</td>
                        <td class="text-center">Hard Copy</td>
                        <td class="text-center">Answer Books</td>

                    </tr>

                </thead>
                <tbody>

                    @foreach($section->course_allocations()->current()->assigned()->get() as $course_allocation)
                    <tr>
                        @if($loop->index==0)
                        <td class="text-center" rowspan="{{$section->course_allocations()->current()->assigned()->count()}}">{{ $section->title() }}</td>
                        @endif
                        <td class="text-center py-3">{{ $loop->index+1 }}</td>
                        <td class="pl-2">{{ $course_allocation->course->name }}</td>
                        <td class="text-center">{{ $course_allocation->course->cr() }}</td>
                        <td class="text-center">{{ $course_allocation->course->code }}</td>
                        <td class="pl-2">{{ $course_allocation->teacher->name ?? '' }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <footer class="footer">
                <table class="mt-8 w-full">
                    <tbody>
                        <tr class="text-xs text-center">
                            <td style="color:#777; font-size:10px">Sign & date</td>
                            <td style="color:#777; font-size:10px">Sign & date</td>
                        </tr>
                        <tr class="text-xs text-center">
                            <td>__________________</td>
                            <td>__________________</td>
                        </tr>
                        <tr class="text-xs text-center">
                            <td class="font-bold ">
                                @if($section->clas->program->internal_id)
                                {{$section->clas->program->internal->name}}
                                @else
                                -
                                @endif
                            </td>
                            <td class="font-bold ">{{$section->clas->program->department->headship->user->name}}</td>
                        </tr>
                        <tr class="text-xs text-center">
                            <td style="color:#666; font-size:12px">Incharge Internal Examination</td>
                            <td style="color:#666; font-size:12px">Chairperson / HOD / Incharge</td>
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
            @if(!$section->is($clas->sections->last()))
            <div class="page-break"></div>
            @endif
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