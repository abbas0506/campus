<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyExceptionController extends Controller
{
    //
    public function show($code)
    {
        if ($code == 0) $msg = "USER HAS BEEN BLOCKED";
        elseif ($code == 1) $msg = "ROLE NOT CLEAR";
        elseif ($code == 2) $msg = "DEPARTMENT INFO MISSING";
        elseif ($code == 3) $msg = "SEMESTER INFO MISSING";
        elseif ($code == 4) $msg = "OTP Verification Required";
        else $msg = "UNDEFINED EXCEPTION";

        return view('exceptions.show', compact('msg'));
    }
}
