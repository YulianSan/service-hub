<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'status',
    ];

    protected $casts = [
        'status' => TicketStatus::class
    ];

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasOne(TicketDetail::class);
    }
}
