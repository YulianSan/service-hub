<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'description'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
