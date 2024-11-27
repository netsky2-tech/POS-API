<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Relationships
     */

     public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
     {
         return $this->belongsToMany(Permission::class);
     }

     public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
     {
         return $this->belongsToMany(User::class);
     }

    public function menus(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}
