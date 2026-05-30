<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'termin_id',
        'attended'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function termin(): BelongsTo
    {
        return $this->belongsTo(Termin::class);
    }
}
