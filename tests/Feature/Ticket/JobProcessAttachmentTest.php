<?php

use App\Models\Ticket;
use App\Models\Attachment;
use App\Services\TicketAttachmentService;
use App\Jobs\ProcessTicketAttachment;
use App\Enums\TicketStatus;
use App\Models\Company;
use App\Models\Project;
use App\Models\TicketDetail;
use App\Models\User;
use App\Notifications\AttachmentProcessed;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();

    $this->user = User::factory()->create([
        'company_id' => $this->company->id
    ]);

    $this->project = Project::factory()->create([
        'company_id' => $this->company->id
    ]);
});


it('processes a JSON attachment and updates ticket detail', function () {
    $ticket = Ticket::factory()->create([
        'status' => TicketStatus::PENDING_ATTACHMENT_PROCESSING,
        'project_id' => $this->project->id,
        'user_id' => $this->user->id
    ]);

    $jsonData = [
        'errors' => 'TimeoutException',
        'technical_notes' => 'App/Service.php:45',
        'metadata' => ['test' => 'production']
    ];
    $jsonContent = json_encode($jsonData);

    Notification::fake();
    Storage::fake('local');
    $path = 'attachments/test.json';
    Storage::put($path, $jsonContent);

    $attachment = $ticket->attachment()->create([
        'filename' => 'test.json',
        'path' => $path,
        'mime_type' => 'json',
        'size' => strlen($jsonContent),
    ]);

    $service = new TicketAttachmentService();

    $job = new ProcessTicketAttachment($attachment->id, $service);
    $job->handle();

    $ticketDetail = TicketDetail::where('ticket_id', $ticket->id)->first();
    expect($ticketDetail->errors)->toBe('TimeoutException');
    expect($ticketDetail->technical_notes)->toBe('App/Service.php:45');
    expect($ticketDetail->metadata)->toBe(['test' => 'production']);

    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'status' => TicketStatus::OPEN
    ]);

    Notification::assertSentTo(
        [$this->user],
        AttachmentProcessed::class,
        function ($notification, $channels) use ($ticket) {
            return $notification->data['ticket_id'] === $ticket->id
                && $notification->data['message'] === 'Attachment processed successfully';
        }
    );
});
