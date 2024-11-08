<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * Relationships
     */

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
