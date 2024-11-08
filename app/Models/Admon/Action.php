<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    /**
     * Relationships
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
