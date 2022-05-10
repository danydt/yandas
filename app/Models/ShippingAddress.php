<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $country_name
 * @property mixed|string $address_l1
 * @property mixed|string $address_l2
 * @property mixed|string $phone_number
 * @property mixed|string $postal_code
 */
class ShippingAddress extends Model
{
    use HasFactory;
}
