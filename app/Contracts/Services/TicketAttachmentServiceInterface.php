<?php

namespace App\Contracts\Services;

interface TicketAttachmentServiceInterface
{
    public function parseJson(string $content): array;
}
