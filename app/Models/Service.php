<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_svg',
        'color',
        'tags',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'tags'      => 'array',
        'is_active' => 'boolean',
    ];
}
