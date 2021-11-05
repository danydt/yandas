<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $code
 * @property string $name
 */
class Currency extends Model
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
}
