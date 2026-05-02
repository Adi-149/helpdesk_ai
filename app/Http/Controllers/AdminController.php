<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with users and support staff.
     */
    public function index(): View
    {
        $users = User::where('role', 'user')->get();
        $supportStaff = User::where('role', 'support')->get();
        $admins = User::where('role', 'admin')->get();

        return view('admin.dashboard', [
            'users' => $users,
            'supportStaff' => $supportStaff,
            'admins' => $admins,
        ]);
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:user,support,admin'],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Role pengguna berhasil diperbarui.');
    }

    /**
     * Delete a user and set their tickets to NULL.
     */
    public function deleteUser(Request $request, User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak dapat menghapus akun admin Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Pengguna berhasil dihapus.');
    }
}
