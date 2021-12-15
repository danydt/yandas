<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float $amount_to_pay
 * @property int $currency_id
 * @property false|mixed|string $attachment
 * @property int $order_id
 * @property string $code
 * @property int $payment_modality
 * @property string $order_code
 * @property Order $order
 */
class Proforma extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getOrderCodeAttribute()
    {
        return $this->order()->value('code');
    }
}
