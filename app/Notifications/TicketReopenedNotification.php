<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;
use App\Models\User;

class TicketReopenedNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $user;

    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
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
            'message' => "Tiket '#{$this->ticket->id} - {$this->ticket->subject}' telah dibuka kembali oleh user.",
            'sender_name' => $this->user->name,
            'type' => 'reopened',
        ];
    }
}
