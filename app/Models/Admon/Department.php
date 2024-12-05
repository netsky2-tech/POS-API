<?php

namespace App\Models\Admon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function municipalities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
