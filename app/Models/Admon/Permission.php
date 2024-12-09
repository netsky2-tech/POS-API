<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $actionId)
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * Relationships
     */

    public function actions()
    {
        return $this->belongsTo(Action::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
