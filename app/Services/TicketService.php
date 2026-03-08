<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Jobs\ProcessTicketAttachment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class TicketService
{
    public function create(array $data, User $user, ?UploadedFile $file = null): Ticket
    {
        $ticket = Ticket::create(
            $data + [
                'user_id' => $user->id,
                'status' => $file
                    ? TicketStatus::PENDING_ATTACHMENT_PROCESSING
                    : TicketStatus::OPEN
            ]
        );

        if ($file) {
            $this->saveAttachment($ticket, $file);
        }

        return $ticket;
    }

    public function update(Ticket $ticket, array $data, ?UploadedFile $file = null): Ticket
    {
        $ticket->update(
            $data + [
                'status' => $file
                    ? TicketStatus::PENDING_ATTACHMENT_PROCESSING
                    : $ticket->status
            ]
        );

        if ($file) {
            if ($ticket->attachment) {
                Storage::delete($ticket->attachment->path);
                $ticket->attachment->delete();
            }

            $this->saveAttachment($ticket, $file);
        }

        return $ticket;
    }

    protected function saveAttachment(Ticket $ticket, UploadedFile $file)
    {
        $filename = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

        $path = Storage::putFileAs('attachments', $file, $filename);

        $attachment = $ticket->attachment()->create([
            'filename' => $filename,
            'path' => $path,
            'mime_type' => $file->getClientOriginalExtension(),
            'size' => $file->getSize()
        ]);

        ProcessTicketAttachment::dispatch(
            $attachment->id,
            new TicketAttachmentService
        );
    }
}
