<?php

namespace App\Jobs;

use App\Enums\TicketStatus;
use App\Models\Attachment;
use App\Services\TicketAttachmentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessTicketAttachment implements ShouldQueue
{
    use Queueable, Dispatchable, SerializesModels;

    public function __construct(
        private Attachment $attachment,
        private TicketAttachmentService $ticketAttachmentService
    ) {}

    public function handle(): void
    {
        $ticket = $this->attachment->attachable;

        if (!$ticket || $ticket->status !== TicketStatus::PENDING_ATTACHMENT_PROCESSING) {
            return;
        }

        $ticket->update([
            'status' => TicketStatus::PROCESSING_ATTACHMENTS
        ]);

        $content = Storage::get($this->attachment->path);
        $data = $this->ticketAttachmentService->parseJson($content);

        $ticket->details()->updateOrCreate(['ticket_id' => $ticket->id], $data);
    }
}
