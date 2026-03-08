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

    protected $casts = [
        'metadata' => 'array'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
