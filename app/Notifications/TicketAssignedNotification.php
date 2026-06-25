<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;
use App\Models\User;

class TicketAssignedNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $assigner;

    public function __construct(Ticket $ticket, User $assigner)
    {
        $this->ticket = $ticket;
        $this->assigner = $assigner;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'message' => "Tiket Anda '#{$this->ticket->id} - {$this->ticket->subject}' telah ditugaskan ke teknisi {$this->assigner->name}.",
            'sender_name' => $this->assigner->name,
            'type' => 'assigned',
        ];
    }
}
