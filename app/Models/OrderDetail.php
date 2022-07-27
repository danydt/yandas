<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property string $product_name
 * @property string $product_url
 * @property int $quantity
 * @property string $description
 */
class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}