<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketCreatedNotification extends Notification
{
    use Queueable;

    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $creatorName = $this->ticket->user ? $this->ticket->user->name : 'Pengguna';
        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'message' => "Tiket baru '#{$this->ticket->id} - {$this->ticket->subject}' telah dibuat oleh {$creatorName}.",
            'sender_name' => $creatorName,
            'type' => 'created',
        ];
    }
}
