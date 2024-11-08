<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Relationships
     */

     public function permissions()
     {
         return $this->belongsToMany(Permission::class);
     }

     public function users()
     {
         return $this->belongsToMany(User::class);
     }
}
