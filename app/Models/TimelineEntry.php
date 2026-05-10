<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    protected $fillable = [
        'date_label',
        'title',
        'organization',
        'type',
        'description',
        'icon',
        'sort_order',
    ];
}
