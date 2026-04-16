<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        $tempPassword = Str::random(10);

        User::create([
            'name'                => $request->name,
            'email'               => $request->email,
            'password'            => Hash::make($tempPassword),
            'is_approved'         => true,
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.users')->with('new_user', [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $tempPassword,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users')->with('success', 'Utente aggiornato.');
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Utente approvato.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'Non puoi eliminare te stesso.']);
        }

        $user->delete();

        return redirect()->back()->with('success', 'Utente eliminato.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);

        $user->update([
            'password'            => Hash::make($newPassword),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.users')->with('reset_user', [
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => $newPassword,
        ]);
    }

    public function toggleSuperAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'Non puoi modificare te stesso.']);
        }

        $user->update(['is_super_admin' => ! $user->is_super_admin]);

        return redirect()->back()->with('success', 'Stato super admin aggiornato.');
    }
}
