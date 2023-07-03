<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateChat extends Model
{
    use HasFactory;

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userOne_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userTwo_id');
    }
}
