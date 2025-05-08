<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $fillable = [
        'contact_id',
        'template_id',
        'subject',
        'body',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}

