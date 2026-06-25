<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;
use App\Models\TicketMessage;

class NewTicketMessageNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $message;

    public function __construct(Ticket $ticket, TicketMessage $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $senderName = $this->message->user ? $this->message->user->name : 'Pengguna';
        return [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'message' => "Ada pesan baru pada tiket '#{$this->ticket->id} - {$this->ticket->subject}' dari {$senderName}.",
            'sender_name' => $senderName,
            'type' => 'message_sent',
        ];
    }
}
