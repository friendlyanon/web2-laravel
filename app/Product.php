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
        'tax_id',
    ];

    protected static $headers = [
        'name' => 'name',
        'quantity' => 'quantity',
        'unit' => 'unit',
        'net_price' => 'net_price',
        'tax' => 'tax.tax',
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
