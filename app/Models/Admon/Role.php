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

     public function permissions()
     {
         return $this->belongsToMany(Permission::class);
     }

     public function users()
     {
         return $this->belongsToMany(User::class);
     }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
