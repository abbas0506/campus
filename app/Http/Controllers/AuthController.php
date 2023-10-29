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

        // echo $request->email;
        try {
            if (Auth::attempt($credentials)) {
                Auth::user()->sendCode();

                return redirect('two/fa');
            } else {
                return redirect()->back()->withErrors(['auth' => 'User credentials incorrect !']);
            }
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    // login step2
    public function loginAs(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'department_id' => 'required_if:role,super,hod,internal,coordinator',
        ]);


        if (Auth::user()->hasRole($request->role)) {
            // get the latest of active semesters
            $semester = Semester::active()->orderBy('id', 'desc')->first();
            session([
                'role' => $request->role,
                'semester_id' => $semester->id,
            ]);

            if ($request->role != 'teacher') {
                $department = Department::find($request->department_id);
                session([
                    'department_id' => $request->department_id,
                ]);
            }
            // //save selected semester id for entire session
            // if (Auth::user()->hasAnyRole('super', 'hod', 'internal', 'coordinator', 'teacher')) {
            //     $semester = Semester::find($request->semester_id);
            //     session([
            //         'semester_id' => $request->semester_id,
            //     ]);
            //     if ($request->role == 'super' || $request->role == 'hod' || $request->role == 'internal' || $request->role == 'coordinator') {
            //         $department = Department::find($request->department_id);
            //         session([
            //             'department_id' => $request->department_id,
            //         ]);
            //     }
            // }
            return redirect($request->role);
        } else
            return redirect('/');
    }


    public function twoFA(Request $request)
    {
        //get 2nd factor secret code sent to gmail
        //if matched, redirect to user dashboard
        $request->validate([
            'code' => 'required',
        ]);

        $find = TwoFa::where('user_id', auth()->user()->id)
            ->where('code', $request->code)
            ->where('updated_at', '>=', now()->subMinutes(2))
            ->first();

        if (!is_null($find)) {

            session([
                'user_2fa' => auth()->user()->id,
            ]);

            return redirect('/');
        }

        return back()->with('warning', 'You entered wrong code.');
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
    public function switchSemester(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|numeric',

        ]);
        session([
            'semester_id' => $request->semester_id,
        ]);
        return redirect(session('role'));
    }

    //switch current role
    public function switchRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|numeric',

        ]);
        session([
            'role_id' => $request->role_id,
            'role' => $request->role,
        ]);
        return redirect(session('role'));
    }
    public function resetPassword(Request $request, $id)
    {
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        //change password process
        $request->validate([
            'current' => 'required',
            'new' => 'required',
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
}
