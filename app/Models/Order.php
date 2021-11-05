<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function proformas(): HasMany
    {
        return $this->hasMany(Proforma::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getClientNameAttribute()
    {
        return $this->user()->value('name');
    }

    public function getProformaAmountAttribute()
    {
        return $this->proformas()->where('enabled', 'true')->value('amount_to_pay');
    }

    public function getProformaCurrencyAttribute()
    {
        return $this->proformas()->orderByDesc('id')->first()->currency()->value('code');
    }
}
