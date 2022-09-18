<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt($credentials)) {
            // return redirect('/');

            return view('second_factor');
        } else {

            return redirect()->back()->withErrors(['auth' => 'User credentials incorrect !']);
        }
    }

    public function verify_second_factor(Request $request)
    {
        //get 2nd factor secret code sent to gmail
        //if matched, redirect to user dashboard
        return redirect('/');
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
        $user = User::find($id);
        //signup  process
        $request->validate([
            'current' => 'required',
            'new' => 'required',
        ]);

        //echo 'current:' . $request->current . "new" . $request->new . "existing" . $user->password;
        try {

            if (Hash::check($request->current, $user->password)) {
                $user->password = Hash::make($request->new);
                $user->save();
                return redirect()->back()->with('success', 'successfuly changed');
            } else {
                //password not found
                return redirect()->back()->withErrors("Password not found");;
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage());
            // something went wrong
        }
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
}
