<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'max_capacity',
    ];

    public function termins(): HasMany
    {
        return $this->hasMany(Termin::class);
    }
}
