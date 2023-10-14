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
                            <td class="text-center text-m">Scheme</td>
                        </tr>
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