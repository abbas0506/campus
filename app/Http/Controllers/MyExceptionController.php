<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyExceptionController extends Controller
{
    //
    public function show($code)
    {
        if ($code == 0) $msg = "User Has Been Blocked, Contact Admin!";
        elseif ($code == 1) $msg = "OTP Verification Required";
        elseif ($code == 2) $msg = "User Role Undefined";
        elseif ($code == 3) $msg = "User Department Undefined";
        elseif ($code == 4) $msg = "Semester Information Missing";
        else $msg = "Some Unknown Exception";

        return view('exceptions.show', compact('msg'));
    }
}
