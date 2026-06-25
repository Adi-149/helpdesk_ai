<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;
use App\Models\User;

class TicketStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $updater;
    protected $changes;

    public function __construct(Ticket $ticket, User $updater, array $changes)
    {
        $this->ticket = $ticket;
        $this->updater = $updater;
        $this->changes = $changes;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $changesString = implode(', ', $this->changes);
        $statusLabels = [
            'open' => 'Dibuka',
            'progress' => 'Sedang Diproses',
            'resolved' => 'Diselesaikan',
            'closed' => 'Ditutup',
        ];
        
        $newStatusLabel = $statusLabels[$this->ticket->status] ?? $this->ticket->status;
        if ($this->ticket->status === 'open' && $this->ticket->assigned_to) {
            $newStatusLabel = 'Ditangani';
        }

        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'message' => "Status tiket Anda '#{$this->ticket->id} - {$this->ticket->subject}' telah diperbarui menjadi {$newStatusLabel} oleh {$this->updater->name}.",
            'sender_name' => $this->updater->name,
            'changes' => $changesString,
            'type' => 'status_updated',
        ];
    }
}
