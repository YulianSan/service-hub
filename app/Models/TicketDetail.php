<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    protected $fillable = [
        'ticket_id',
        'errors',
        'technical_notes',
        'metadata',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
