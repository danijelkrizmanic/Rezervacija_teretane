<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->get();

        return view('users.index', compact('users'));
    }

    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ], [
            'role.required' => 'Please select a role.',
            'role.exists' => 'The selected role does not exist.',
        ]);

        $user->syncRoles($validated['role']);

        return redirect('/users')->with('success', 'User role has been updated!');
    }
}
