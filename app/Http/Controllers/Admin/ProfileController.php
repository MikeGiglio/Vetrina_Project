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
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password'             => Hash::make($request->new_password),
            'must_change_password' => false,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Password aggiornata con successo.');
    }
}
