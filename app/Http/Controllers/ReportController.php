<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show the admin reports page with comprehensive ticket statistics.
     */
    public function index(Request $request)
    {
        // --- Filter parameters ---
        $filterStatus = $request->query('status');
        $filterPriority = $request->query('priority');
        $filterCategory = $request->query('category');
        $filterDateFrom = $request->query('date_from');
        $filterDateTo = $request->query('date_to');

        // --- Summary counts (always unfiltered) ---
        $totalTickets = Ticket::count();
        $ticketsByStatus = [
            'open' => Ticket::where('status', 'open')->count(),
            'progress' => Ticket::where('status', 'progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];

        // --- Tickets by category ---
        $ticketsByCategory = Ticket::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // --- Tickets by priority ---
        $ticketsByPriority = [
            'high' => Ticket::where('priority', 'high')->count(),
            'medium' => Ticket::where('priority', 'medium')->count(),
            'low' => Ticket::where('priority', 'low')->count(),
        ];

        // --- Technician performance ---
        $supportStaff = User::where('role', 'support')->get()->map(function ($staff) {
            $staff->assigned_count = Ticket::where('assigned_to', $staff->id)->count();
            $staff->resolved_count = Ticket::where('assigned_to', $staff->id)
                ->whereIn('status', ['resolved', 'closed'])
                ->count();
            $staff->progress_count = Ticket::where('assigned_to', $staff->id)
                ->where('status', 'progress')
                ->count();
            return $staff;
        });

        // --- Monthly trend (last 6 months) ---
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->translatedFormat('M Y'),
                'total' => Ticket::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'resolved' => Ticket::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->whereIn('status', ['resolved', 'closed'])
                    ->count(),
            ];
        }

        // --- Filtered ticket list ---
        $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest();

        if ($filterStatus) {
            $ticketsQuery->where('status', $filterStatus);
        }
        if ($filterPriority) {
            $ticketsQuery->where('priority', $filterPriority);
        }
        if ($filterCategory) {
            $ticketsQuery->where('category', $filterCategory);
        }
        if ($filterDateFrom) {
            $ticketsQuery->whereDate('created_at', '>=', $filterDateFrom);
        }
        if ($filterDateTo) {
            $ticketsQuery->whereDate('created_at', '<=', $filterDateTo);
        }

        $tickets = $ticketsQuery->paginate(15)->appends($request->query());

        // --- All categories for filter dropdown ---
        $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.reports', compact(
            'totalTickets',
            'ticketsByStatus',
            'ticketsByCategory',
            'ticketsByPriority',
            'supportStaff',
            'monthlyData',
            'tickets',
            'categories',
            'filterStatus',
            'filterPriority',
            'filterCategory',
            'filterDateFrom',
            'filterDateTo'
        ));
    }
}
