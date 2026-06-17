<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueStatus extends Model
{
    protected $fillable = [
        'key', 'label', 'sort_order',
    ];
}
