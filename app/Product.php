<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'net_price',
        'quantity',
        'tariff',
        'tax_id',
    ];

    protected static $headers = [
        'id' => 'id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
