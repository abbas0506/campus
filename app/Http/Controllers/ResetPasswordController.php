<?php

namespace App\Http\Controllers;

use App\Models\TwoFa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Svg\Tag\Rect;

class ResetPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //send password reset code

        Auth::user()->sendCode();
        return view('reset_password');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $request->validate([
            'code' => 'required',
        ]);

        $matched = TwoFa::where('user_id', auth()->user()->id)
            ->where('code', $request->code)
            ->where('updated_at', '>=', now()->subMinutes(2))
            ->first();

        if ($matched) {

            $user = Auth::user();
            //change password process
            $request->validate([
                'new' => 'required',
            ]);

            try {

                $user->password = Hash::make($request->new);
                $user->update();
                return redirect()->back()->with('success', 'successfuly changed');
            } catch (Exception $e) {
                return redirect()->back()
                    ->withErrors($e->getMessage());
                // something went wrong
            }

            return redirect('/');
        }

        return back()->with('warning', 'You entered wrong code.');
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
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $code = rand(1000, 9999);
            TwoFa::updateOrCreate(
                ['user_id' => $user->id],
                ['code' => $code]
            );

            try {

                Mail::raw('Password reset code', function ($message) use ($code, $email) {
                    $message->to($email);
                    $message->subject($code);
                });

                return redirect()->route('resetpassword.index');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            return redirect()->back()->with('warning', 'The email does not exist in record');
        }
    }
}
