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
                            <td class="text-center text-lg">Study Scheme</td>
                        </tr>
                    </tbody>
                </table>

                @php
                $roman=config('global.romans');
                @endphp
                <!--scheme detail -->
                <table class="table-fixed w-full mt-2">
                    <thead>
                        <tr>
                            <th colspan=2 style="border-bottom:1px solid #888;">{{$scheme->title()}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scheme->semester_nos() as $semester_no)
                        <tr>
                            <td colspan="3" class="text-sm">Semester {{$roman[$semester_no-1]}}</td>
                        </tr>
                        @foreach($scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot)
                        <tr class="even:bg-slate-100 text-xs">
                            <td class="text-center">{{$slot->slot_no}}</td>
                            <td class="py-0">
                                <table class="w-full">
                                    <tbody>
                                        @foreach($slot->slot_options as $slot_option)
                                        <tr>
                                            <td class="w-32">{{$slot_option->course_type->name}} <span class="text-xs text-slate-400">({{$slot->cr}})</span></td>
                                            @if($slot_option->course()->exists())
                                            <td class="w-24">{{$slot_option->course->code}}</td>
                                            <td class="w-80 text-left">{{$slot_option->course->name}} <span class="text-xs text-slate-400">{{$slot_option->course->lblCr()}}</span></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
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