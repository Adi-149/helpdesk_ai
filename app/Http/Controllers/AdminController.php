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
        $totalTickets = \App\Models\Ticket::count();

        // Statistik Status Tiket
        $statusCounts = [
            'open' => \App\Models\Ticket::where('status', 'open')->count(),
            'progress' => \App\Models\Ticket::where('status', 'progress')->count(),
            'resolved' => \App\Models\Ticket::where('status', 'resolved')->count(),
            'closed' => \App\Models\Ticket::where('status', 'closed')->count(),
        ];

        // Statistik Prioritas Tiket
        $priorityCounts = [
            'high' => \App\Models\Ticket::where('priority', 'high')->count(),
            'medium' => \App\Models\Ticket::where('priority', 'medium')->count(),
            'low' => \App\Models\Ticket::where('priority', 'low')->count(),
        ];

        // Statistik Kategori Tiket
        $categoryCounts = [
            'Hardware' => \App\Models\Ticket::where('category', 'Hardware')->count(),
            'Software' => \App\Models\Ticket::where('category', 'Software')->count(),
            'Jaringan' => \App\Models\Ticket::where('category', 'Jaringan')->count(),
            'Akun' => \App\Models\Ticket::where('category', 'Akun')->count(),
            'Lainnya' => \App\Models\Ticket::where('category', 'Lainnya')->count(),
        ];

        return view('admin.dashboard', [
            'users' => $users,
            'supportStaff' => $supportStaff,
            'admins' => $admins,
            'totalTickets' => $totalTickets,
            'statusCounts' => $statusCounts,
            'priorityCounts' => $priorityCounts,
            'categoryCounts' => $categoryCounts,
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
