<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TicketHistory;

class TicketController extends Controller
{
    public function index()
    {
        // Jika support, redirect ke support.tickets
        if (auth()->user()->role === 'support') {
            return redirect()->route('support.tickets');
        }
        
        // Regular user: tampilkan ticket mereka saja
        $tickets = Ticket::where('user_id', auth()->id())->latest()->get();
        return view('tickets.index', compact('tickets'));
    }


    public function assignForm($id)
{
    $ticket = Ticket::findOrFail($id);
    $supports = User::where('role', 'support')->get();

    return view('support.assign', compact('ticket','supports'));
}

public function assign(Request $request, $id)
{
    $request->validate([
        'assigned_to' => 'required|exists:users,id',
    ]);

    $ticket = Ticket::findOrFail($id);
    $ticket->assigned_to = $request->assigned_to;
    $ticket->status = 'progress';
    $ticket->save();

    return redirect()->route('support.tickets')
        ->with('success','Ticket berhasil di-assign');
}

    public function create()
    {
        return view('tickets.create');
    }

    public function all()
{
    $tickets = Ticket::latest()->get();
    return view('support.tickets', compact('tickets'));
}


    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $supports = User::where('role', 'support')->get();
        return view('tickets.show', compact('ticket', 'supports'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,progress,resolved,closed',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $ticket = Ticket::findOrFail($id);
        $oldStatus = $ticket->status;
        $oldPriority = $ticket->priority;
        $oldAssignedTo = $ticket->assigned_to;

        $ticket->status = $request->status;
        $ticket->priority = $request->priority;
        if ($request->assigned_to) {
            $ticket->assigned_to = $request->assigned_to;
        }
        $ticket->save();

        // Simpan history
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success','Ticket berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'category' => 'required',
            'priority' => 'required',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
        ]);

        return redirect()->route('tickets.index')->with('success','Ticket berhasil dibuat');
    }
}
