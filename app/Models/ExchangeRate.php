<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = ['base_currency_id', 'target_currency_id', 'exchange_rate', 'valid_from', 'valid_to'];

    public function baseCurrency(): belongsTo
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }

    public function targetCurrency(): belongsTo
    {
        return $this->belongsTo(Currency::class, 'target_currency_id');
    }
}
