<?php

namespace App\Services;

use App\Contracts\Services\TicketAttachmentServiceInterface;

class TicketAttachmentService implements TicketAttachmentServiceInterface
{
    public function parseJson(string $content): array
    {
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid json: ' . json_last_error_msg());
        }

        $data['metadata'] = $data['metadata'] ?? [];

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid metadata json: ' . json_last_error_msg());
        }

        $data['errors'] = $data['errors'] ?? '';
        $data['technical_notes'] = $data['technical_notes'] ?? '';

        return $data;
    }
}
