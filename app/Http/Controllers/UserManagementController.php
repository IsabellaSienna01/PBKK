<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage-users');
    }

    public function index(): View
    {
        $users = User::with('roles', 'permissions')->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('dashboard.users.index')
            ->with('success', "User {$user->name} created successfully with {$request->role} role.");
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        // Prevent admin from removing their own admin role
        if ($user->id === Auth::id() && $request->role !== 'Admin') {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'You cannot demote your own account role.');
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('dashboard.users.index')
            ->with('success', "Role for {$user->name} updated successfully to {$request->role}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', "Account {$name} deleted successfully.");
    }
}
