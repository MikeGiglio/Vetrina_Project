<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showChangePassword()
    {
        return view('admin.password.change');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $rules = ['new_password' => ['required', 'string', 'min:8', 'confirmed']];

        if (! $user->must_change_password) {
            $rules['current_password'] = ['required', 'string'];
        }

        $request->validate($rules);

        if (! $user->must_change_password && ! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La password attuale non è corretta.']);
        }

        $user->update([
            'password'             => Hash::make($request->new_password),
            'must_change_password' => false,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Password aggiornata con successo.');
    }
}
