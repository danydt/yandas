<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre',
        'phone_number',
        'birthday',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
