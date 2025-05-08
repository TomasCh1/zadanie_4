<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',      // unikátny kľúčový názov
        'subject',   // predmet e-mailu
        'body',      // raw Blade telo
        'is_html',   // boolean, či ide o HTML
    ];
}

