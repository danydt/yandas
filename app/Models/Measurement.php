<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float|mixed $length
 * @property float|mixed $width
 * @property float|mixed $height
 * @property float|mixed $weight
 */
class Measurement extends Model
{
    use HasFactory;
}
