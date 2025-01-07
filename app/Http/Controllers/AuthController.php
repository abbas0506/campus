<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Semester;
use App\Models\TwoFa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use Exception;

class AuthController extends Controller
{
    //
    public function signup(Request $request)
    {
        //signup  process
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required',

        ]);

        try {

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            Auth::login($user);

            return redirect('/');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        // if credentials matched, send OTP;
        try {
            if (Auth::attempt($credentials)) {
                Auth::user()->sendCode();
                return redirect('verify/otp');
            }
            // if credential not matched, show warning
            return redirect()->back()->withErrors(['auth' => 'User credentials incorrect !']);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function signout()
    {
        //destroy session
        session()->flush();
        Auth::logout();

        return redirect('/');
    }

    // switch semester
    public function viewSwitch()
    {
        $roles = Auth::user()->roles;
        $semesters = Semester::active()->get();
        return view('switch', compact('roles', 'semesters'));
    }
    public function switch(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'semester_id' => 'required|numeric',

        ]);

        if (session('role') == 'teacher' && $request->role != 'teacher') {
            if ($request->department_id) {
                session([
                    'department_id' => $request->department_id,
                ]);
            } else {
                return redirect()->back()->with('warning', 'Department missing!');;
            }
        }
        // if every thing ok, switch to new mode
        // update session
        session([
            'role' => $request->role,
            'semester_id' => $request->semester_id,
        ]);
        return redirect(session('role'));
    }

    //switch current role
    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //change password process
        $request->validate([
            'current' => 'required',
            'new' => 'required|min:8',
        ]);

        try {

            if (Hash::check($request->current, $user->password)) {
                $user->password = Hash::make($request->new);
                $user->save();
                return redirect()->route('passwords.confirm')->with('success', 'Password successfuly changed');
            } else {
                //password not found
                return redirect()->back()->with('warning', 'Oops, something wrong!');;
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function verifyOTP(Request $request)
    {
        //if OTP verified, redirect to role selection
        $request->validate([
            'otp' => 'required',
        ]);

        $OTPVerified = TwoFa::where('user_id', auth()->user()->id)
            ->where('code', $request->otp)
            ->where('updated_at', '>=', now()->subMinutes(5))
            ->first();

        if ($OTPVerified) {
            session([
                'otp_verified' => 1,
            ]);
            return redirect('role-selection');
        }
        return back()->with('warning', 'Invalid OTP! ');
    }

    public function selectRole()
    {

        $user = Auth::user();
        // if has only one role, skip role selection
        if ($user->roles->count() == 1 && $user->hasAnyRole(['admin', 'teacher'])) {
            session([
                'role' => $user->roles->first()->name,
                'semester_id' => Semester::where('status', 1)->first()->id,
            ]);
            return redirect($user->roles->first()->name);
        }
        // otherwise redirect to role selectin page
        if (session('otp_verified'))
            return view('role-selection');
        else
            return redirect('verify/otp');
    }

    // login step2
    public function loginAs(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'department_id' => 'required_if:role,super,hod,internal,coordinator',
        ]);


        if (Auth::user()->hasRole($request->role)) {
            // start user session
            session(['role' => $request->role,]);

            if ($request->role == 'admin')
                return redirect('admin');

            $semester = Semester::where('status', 1)->orderBy('id', 'desc')->first();
            session(['semester_id' => $semester->id,]);

            // teacher does not require department selection 
            if ($request->role == 'teacher')
                return redirect('teacher');

            // only super, HOD, internal, coordinator require department selection
            if (in_array($request->role, ['super', 'hod', 'internal', 'coordinator'])) {
                $department = Department::findOrFail($request->department_id);
                session([
                    'department_id' => $department->id,
                ]);
            }
            // redirect to user dashboard
            return redirect($request->role);
        } else
            return redirect('/');
    }
}
