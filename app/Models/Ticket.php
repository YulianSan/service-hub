<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'status',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
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
