<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property bool $enabled
 * @property string $code
 * @property string $client_name
 * @property mixed|string $external_code
 * @property mixed|string $internal_code
 * @property mixed $paid_amount
 * @property mixed $proforma_amount
 * @method static searchOrders(string $term, int|string|null $user_id)
 */
class Order extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'internal_code';
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

    public function followings(): HasMany
    {
        return $this->hasMany(Following::class);
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

    public function getProformaCodeAttribute()
    {
        return $this->proformas()->orderByDesc('id')->first()?->value('code');
    }

    public function getDetailCountAttribute(): int
    {
        return $this->details()->count();
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()->sum('paid_amount');
    }

    public function scopeAvailableOrdersCount($query)
    {
        return $query->where([
            'enabled' => 'true',
            'completed' => 'false'
        ])->count();
    }

    public function scopeMyAvailableOrdersCount($query, $user_id)
    {
        return $query->where([
            'enabled' => 'true',
            'completed' => 'false',
            'user_id' => $user_id
        ])->count();
    }

    public function scopeDeliveredOrdersCount($query)
    {
        return $query->where([
            'delivered' => 'true'
        ])->count();
    }

    public function scopeMyDeliveredOrdersCount($query, $user_id)
    {
        return $query->where([
            'delivered' => 'true',
            'user_id' => $user_id
        ])->count();
    }

    /**
     * Return orders tha match the search criteria
     * @param $query
     * @param $term
     * @param $user_id
     * @return mixed
     */
    public function scopeSearchOrders($query, $term, $user_id): mixed
    {
        return $query->where('external_code', 'ilike', '%' . $term . '%')->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->get();
    }
}
