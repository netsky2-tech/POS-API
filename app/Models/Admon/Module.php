<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    /**
     * Relationships
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
