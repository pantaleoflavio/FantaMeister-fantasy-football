<?php

namespace App\Models;

use App\Models\ImportRowError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Import extends Model
{
    protected $fillable = [
        'type',
        'filename',
        'disk',
        'path',
        'status',
        'imported_by_user_id',
        'total_rows',
        'successful_rows',
        'failed_rows',
        'started_at',
        'completed_at'
    ];

    public function importedBy()
    {
        return $this->belongsTo(User::class, 'imported_by_user_id');
    }

    public function rowErrors(): HasMany
    {
        return $this->hasMany(ImportRowError::class);
    }
}
