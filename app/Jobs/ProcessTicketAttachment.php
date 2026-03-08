<?php

namespace App\Jobs;

use App\Enums\TicketStatus;
use App\Models\Attachment;
use App\Notifications\AttachmentProcessed;
use App\Services\TicketAttachmentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProcessTicketAttachment implements ShouldQueue
{
    use Queueable, Dispatchable, SerializesModels;

    public Attachment $attachment;

    public function __construct(
        int $attachment_id,
        public TicketAttachmentService $ticketAttachmentService
    ) {
        $this->attachment = Attachment::find($attachment_id);
    }

    public function handle(): void
    {
        if (!$this->attachment) {
            return;
        }

        $ticket = $this->attachment->attachable;

        if (!$ticket || $ticket->status !== TicketStatus::PENDING_ATTACHMENT_PROCESSING) {
            return;
        }

        try {
            $ticket->update([
                'status' => TicketStatus::PROCESSING_ATTACHMENTS
            ]);

            if (!Storage::exists($this->attachment->path)) {
                return;
            }

            $content = Storage::get($this->attachment->path);
            $data = $this->ticketAttachmentService->parseJson($content);

            $ticket->details()->updateOrCreate(['ticket_id' => $ticket->id], $data);
        } catch (Throwable $e) {
            $ticket->update([
                'status' => TicketStatus::OPEN
            ]);

            Log::error('Error (ProcessTicketAttachment)', [
                'attachment_id' => $this->attachment->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }

        try {
            $ticket->user->notify(new AttachmentProcessed([
                'ticket_id' => $ticket->id,
                'message' => 'Attachment processed successfully'
            ]));
        } catch (\Throwable $e) {
            Log::warning('Error sending notification (ProcessTicketAttachment)', [
                'ticket_id' => $ticket->id,
                'message' => $e->getMessage(),
            ]);
        }

        $ticket->update([
            'status' => TicketStatus::OPEN
        ]);
    }
}
