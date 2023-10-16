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
$roman=config('global.romans');
$prev_slot_no='';
$semester=App\Models\Semester::find(session('semester_id'));
@endphp

<body>
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
                            <td class="text-center text-lg">Semester Plan ({{$semester->title()}})</td>
                        </tr>
                    </tbody>
                </table>


                <!--courseplan detail -->
                @php
                $roman=config('global.romans');
                $semester_no=1;
                @endphp

                <table class="table-fixed w-full mt-4">
                    <thead>
                        <tr>
                            <th colspan=5 style="border-bottom:1px solid #888;">{{$section->title()}}</th>
                        </tr>
                        <tr class="text-xs">
                            <th class="w-8 text-left">Slot</th>
                            <th class="w-24 text-left">Course Type</th>
                            <th class="w-16 text-left">Code</th>
                            <th class="w-40 text-left">Course</th>
                            <th class="w-32 text-left">Teacher</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($section->semesters() as $semester)
                        <tr>
                            <td colspan="4" class="text-sm font-semibold">
                                Semester {{$roman[$semester_no++ - 1]}}
                                <span class="text-xs">({{ $semester->title()}})</span>
                            </td>
                        </tr>
                        @foreach($section->course_allocations()->for($semester->id)->get() as $course_allocation)
                        <tr class="tr text-xs">
                            <td>
                                @if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                                {{$course_allocation->slot_option->slot->slot_no}}
                                @endif
                            </td>
                            <td class="text-left">
                                {{$course_allocation->slot_option->course_type->name}}
                                <span class="text-slate-400 text-xs ml-1">({{ $course_allocation->slot_option->slot->cr }})</span>
                            </td>
                            @if($course_allocation->course()->exists())
                            <td>{{ $course_allocation->course->code }}</td>
                            <td class="text-left">{{ $course_allocation->course->name }}<span class="text-slate-400 text-xs ml-1"> {{ $course_allocation->course->lblCr() }}</span></td>
                            <td class="text-left">{{ $course_allocation->teacher->name??'' }}</td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                        <!-- show slot no only for once to make slot options' group  -->
                        @php
                        if($prev_slot_no!=$course_allocation->slot_option->slot->slot_no)
                        $prev_slot_no=$course_allocation->slot_option->slot->slot_no;
                        @endphp
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
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