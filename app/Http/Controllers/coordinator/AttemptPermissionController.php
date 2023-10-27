<?php

namespace App\Http\Controllers\coordinator;

use App\Http\Controllers\Controller;
use App\Models\FirstAttempt;
use Exception;
use Illuminate\Http\Request;

class AttemptPermissionController extends Controller
{
    // just update status
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'can_appear' => 'required|boolean',
        ]);

        try {

            //allow or deny attempt
            $first_attempt = FirstAttempt::find($id);
            $first_attempt->can_appear = $request->can_appear;
            $first_attempt->update();

            return redirect()->back()->with('success', 'Successfully updated!');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
