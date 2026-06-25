<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_support_and_admin_receive_notification_when_new_ticket_created()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post(route('tickets.store'), [
            'subject' => 'AC Bocor',
            'description' => 'AC di ruang server bocor air',
            'category' => 'Hardware',
        ]);

        $response->assertRedirect(route('tickets.index'));

        // Check if support and admin received the notification
        $this->assertEquals(1, $support->unreadNotifications->count());
        $this->assertEquals(1, $admin->unreadNotifications->count());
        $this->assertEquals(0, $user->unreadNotifications->count());

        $notification = $support->unreadNotifications->first();
        $this->assertEquals('AC Bocor', $notification->data['subject']);
        $this->assertStringContainsString('telah dibuat oleh', $notification->data['message']);
    }

    public function test_user_receives_notification_when_ticket_assigned()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Printer Macet',
            'description' => 'Kertas menyangkut di dalam printer',
            'category' => 'Hardware',
            'priority' => 'low',
            'status' => 'open',
        ]);

        $response = $this->actingAs($support)->post(route('tickets.assign', $ticket->id), [
            'assigned_to' => $support->id,
        ]);

        $response->assertRedirect(route('support.tickets'));

        // Ticket owner should receive the assignment notification
        $this->assertEquals(1, $user->unreadNotifications->count());
        $notification = $user->unreadNotifications->first();
        $this->assertEquals('Printer Macet', $notification->data['subject']);
        $this->assertStringContainsString('telah ditugaskan ke teknisi', $notification->data['message']);
    }

    public function test_user_receives_notification_when_ticket_status_updated()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Aplikasi Error',
            'description' => 'Aplikasi tidak mau terbuka',
            'category' => 'Software',
            'priority' => 'low',
            'status' => 'open',
            'assigned_to' => $support->id,
        ]);

        // Support updates the status to progress
        $response = $this->actingAs($support)->patch(route('tickets.update', $ticket->id), [
            'status' => 'progress',
            'priority' => 'medium',
            'assigned_to' => $support->id,
            'notes' => 'Sedang dicek programnya',
        ]);

        $response->assertRedirect(route('tickets.show', $ticket->id));

        // User should receive status updated notification
        $this->assertEquals(1, $user->unreadNotifications->count());
        $notification = $user->unreadNotifications->first();
        $this->assertEquals('status_updated', $notification->data['type']);
        $this->assertStringContainsString('Sedang Diproses', $notification->data['message']);
    }

    public function test_assigned_support_receives_notification_when_user_sends_chat_message()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Internet Putus',
            'description' => 'Kabel LAN lepas',
            'category' => 'Jaringan',
            'priority' => 'medium',
            'status' => 'progress',
            'assigned_to' => $support->id,
        ]);

        $response = $this->actingAs($user)->post(route('tickets.messages.store', $ticket->id), [
            'message' => 'Halo teknisi, apakah sudah jalan?',
        ]);

        $response->assertRedirect(route('tickets.show', $ticket->id));

        // Assigned support should receive notification
        $this->assertEquals(1, $support->unreadNotifications->count());
        $notification = $support->unreadNotifications->first();
        $this->assertEquals('message_sent', $notification->data['type']);
        $this->assertStringContainsString('Ada pesan baru pada tiket', $notification->data['message']);
    }

    public function test_user_receives_notification_when_support_sends_chat_message()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Internet Putus',
            'description' => 'Kabel LAN lepas',
            'category' => 'Jaringan',
            'priority' => 'medium',
            'status' => 'progress',
            'assigned_to' => $support->id,
        ]);

        $response = $this->actingAs($support)->post(route('tickets.messages.store', $ticket->id), [
            'message' => 'Sudah kami cek, sedang disambungkan kembali.',
        ]);

        $response->assertRedirect(route('tickets.show', $ticket->id));

        // User should receive notification
        $this->assertEquals(1, $user->unreadNotifications->count());
        $notification = $user->unreadNotifications->first();
        $this->assertEquals('message_sent', $notification->data['type']);
    }

    public function test_support_receives_notification_when_user_closes_ticket()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Internet Putus',
            'description' => 'Kabel LAN lepas',
            'category' => 'Jaringan',
            'priority' => 'medium',
            'status' => 'resolved',
            'assigned_to' => $support->id,
        ]);

        $response = $this->actingAs($user)->post(route('tickets.close', $ticket->id));
        $response->assertRedirect(route('tickets.show', $ticket->id));

        // Assigned support should receive closed notification
        $this->assertEquals(1, $support->unreadNotifications->count());
        $notification = $support->unreadNotifications->first();
        $this->assertEquals('closed', $notification->data['type']);
    }

    public function test_support_receives_notification_when_user_reopens_ticket()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Internet Putus',
            'description' => 'Kabel LAN lepas',
            'category' => 'Jaringan',
            'priority' => 'medium',
            'status' => 'closed',
            'assigned_to' => $support->id,
        ]);

        \App\Models\TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'old_status' => 'resolved',
            'new_status' => 'closed',
            'notes' => 'User closed ticket',
        ]);

        $response = $this->actingAs($user)->post(route('tickets.reopen', $ticket->id));
        $response->assertRedirect(route('tickets.show', $ticket->id));

        // Assigned support should receive reopened notification
        $this->assertEquals(1, $support->unreadNotifications->count());
        $notification = $support->unreadNotifications->first();
        $this->assertEquals('reopened', $notification->data['type']);
    }

    public function test_user_can_fetch_unread_and_mark_notifications_as_read()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Printer Macet',
            'description' => 'Kertas menyangkut',
            'category' => 'Hardware',
            'priority' => 'low',
            'status' => 'open',
        ]);

        // Trigger notification by assigning ticket
        $this->actingAs($support)->post(route('tickets.assign', $ticket->id), [
            'assigned_to' => $support->id,
        ]);

        // 1. Fetch unread API
        $response = $this->actingAs($user)->getJson(route('notifications.unread'));
        $response->assertOk();
        $response->assertJsonCount(1, 'notifications');
        $response->assertJsonPath('unread_count', 1);
        $notifId = $response->json('notifications.0.id');

        // 2. Mark specific notification as read
        $responseRead = $this->actingAs($user)->postJson(route('notifications.mark-read', $notifId));
        $responseRead->assertOk();
        $this->assertEquals(0, $user->unreadNotifications->count());

        // Trigger another notification
        $this->actingAs($support)->post(route('tickets.messages.store', $ticket->id), [
            'message' => 'Test message',
        ]);

        // 3. Mark all as read
        $responseReadAll = $this->actingAs($user)->postJson(route('notifications.mark-all-read'));
        $responseReadAll->assertOk();
        $this->assertEquals(0, $user->unreadNotifications->count());
    }

    public function test_user_can_click_notification_to_read_and_redirect()
    {
        $user = User::factory()->create(['role' => 'user']);
        $support = User::factory()->create(['role' => 'support']);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Printer Macet',
            'description' => 'Kertas menyangkut',
            'category' => 'Hardware',
            'priority' => 'low',
            'status' => 'open',
        ]);

        // Trigger notification
        $this->actingAs($support)->post(route('tickets.assign', $ticket->id), [
            'assigned_to' => $support->id,
        ]);

        $notification = $user->unreadNotifications->first();

        // Click notification
        $response = $this->actingAs($user)->get(route('notifications.click', $notification->id));
        $response->assertRedirect(route('tickets.show', $ticket->id));

        // It should be marked as read
        $user->refresh();
        $this->assertEquals(0, $user->unreadNotifications->count());
    }
}
