<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed|string $payment_date
 * @property float|mixed $paid_amount
 * @property int|mixed $order_id
 * @property mixed|string $reference_code
 * @property mixed|string $external_code
 * @property mixed|string $currency_code
 */
class Payment extends Model
{
    use HasFactory;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
