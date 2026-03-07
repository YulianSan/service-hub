<?php

namespace App\Enums;

enum TicketStatus: string
{
    case PENDING_ATTACHMENT_PROCESSING = 'pending_attachment_processing';
    case PROCESSING_ATTACHMENTS = 'processing_attachments';
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case WAITING_CUSTOMER = 'waiting_customer';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
}
