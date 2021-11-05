<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $code
 * @property string $name
 * @property string $default_sidebar
 * @property string $default_dashboard
 * @property string $default_navigation_bar
 */
class Role extends Model
{
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    use HasFactory;
}
