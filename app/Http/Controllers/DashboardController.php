<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function supportDashboard()
    {
        // Total tickets
        $totalTickets = Ticket::count();
        
        // Tickets by status
        $ticketsByStatus = [
            'open' => Ticket::where('status', 'open')->count(),
            'progress' => Ticket::where('status', 'progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];
        
        // Tickets by priority
        $ticketsByPriority = [
            'high' => Ticket::where('priority', 'high')->count(),
            'medium' => Ticket::where('priority', 'medium')->count(),
            'low' => Ticket::where('priority', 'low')->count(),
        ];

        // Tickets by category
        $ticketsByCategory = [
            'Hardware' => Ticket::where('category', 'Hardware')->count(),
            'Software' => Ticket::where('category', 'Software')->count(),
            'Jaringan' => Ticket::where('category', 'Jaringan')->count(),
            'Akun' => Ticket::where('category', 'Akun')->count(),
            'Lainnya' => Ticket::where('category', 'Lainnya')->count(),
        ];
        
        // Belum Ditangani = status open & assigned_to null
        $unassignedTickets = Ticket::where('status', 'open')->whereNull('assigned_to')->count();
        
        // Recent tickets
        $recentTickets = Ticket::latest()->take(5)->get();

        return view('dashboard.support', compact(
            'totalTickets',
            'ticketsByStatus',
            'ticketsByPriority',
            'ticketsByCategory',
            'unassignedTickets',
            'recentTickets'
        ));
    }

    public function userDashboard()
    {
        $userId = auth()->id();
        
        // User's total tickets
        $totalTickets = Ticket::where('user_id', $userId)->count();
        
        // User's tickets by status
        $ticketsByStatus = [
            'open' => Ticket::where('user_id', $userId)->where('status', 'open')->count(),
            'progress' => Ticket::where('user_id', $userId)->where('status', 'progress')->count(),
            'resolved' => Ticket::where('user_id', $userId)->where('status', 'resolved')->count(),
            'closed' => Ticket::where('user_id', $userId)->where('status', 'closed')->count(),
        ];
        
        // User's tickets by priority
        $ticketsByPriority = [
            'high' => Ticket::where('user_id', $userId)->where('priority', 'high')->count(),
            'medium' => Ticket::where('user_id', $userId)->where('priority', 'medium')->count(),
            'low' => Ticket::where('user_id', $userId)->where('priority', 'low')->count(),
        ];
        
        // User's recent tickets
        $recentTickets = Ticket::where('user_id', $userId)->latest()->take(5)->get();

        return view('dashboard.user', compact(
            'totalTickets',
            'ticketsByStatus',
            'ticketsByPriority',
            'recentTickets'
        ));
    }
}
