<?php

namespace App\Services;

class TicketAttachmentService
{
    public function parseJson(string $content): array
    {
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON inválido: ' . json_last_error_msg());
        }

        $data['metadata'] = json_decode($data['metadata'] ?? '{}', true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON inválido metadata: ' . json_last_error_msg());
        }

        $data['errors'] = $data['errors'] ?? '';
        $data['technical_notes'] = $data['technical_notes'] ?? '';

        return $data;
    }
}
