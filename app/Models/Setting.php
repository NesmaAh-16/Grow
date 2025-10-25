<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name','official_email','default_locale','registration_open'
    ];

    protected $casts = [
        'registration_open' => 'boolean',
    ];
}
