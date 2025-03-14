<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        // attach roles to the users
        $users->map(function ($user) {
            $user->role = $user->roles->pluck('name');
        });
        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    // Assign the "admin" role to a user
    public function assignAdmin(User $user)
    {
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        return redirect()->route('users.index');
    }

    // Revoke the "admin" role from a user
    public function revokeAdmin(User $user)
    {
        if ($user->hasRole('admin')) {
            $user->removeRole('admin');
        }

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
