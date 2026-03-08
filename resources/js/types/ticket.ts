export enum TicketStatus {
    PENDING_ATTACHMENT_PROCESSING = 'pending_attachment_processing',
    PROCESSING_ATTACHMENTS = 'processing_attachments',
    OPEN = 'open',
    IN_PROGRESS = 'in_progress',
    WAITING_CUSTOMER = 'waiting_customer',
    RESOLVED = 'resolved',
    CLOSED = 'closed'
}

export interface Ticket {
    id: number;
    project_id: number;
    user_id: number;
    title: string;
    status: TicketStatus;
    created_at: string;
    updated_at: string;
}
