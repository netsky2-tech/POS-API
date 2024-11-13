<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Relationships
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function submenus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
