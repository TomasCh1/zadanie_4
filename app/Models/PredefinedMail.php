<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_ids',
        'template_id',
        'attachments',
        'scheduled_at',
    ];

    protected $casts = [
        'contact_ids' => 'array',
        'attachments' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
