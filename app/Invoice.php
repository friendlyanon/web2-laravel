<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_PAID = 'paid';
    public const STATUS_RECTIFIED = 'rectified';

    public $cardKey = 'id';

    protected $fillable = [
        'quantity',
        'total',
        'partner_group_id',
        'product_id',
        'discount_id',
    ];

    protected static $headers = [
        'id' => 'id',
        'product_name' => 'product.name',
        'quantity' => 'quantity',
        'total' => 'total',
        'partner_group_name' => 'partnerGroup.name',
    ];

    public function partnerGroup(): BelongsTo
    {
        return $this->belongsTo(PartnerGroup::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function canBeEdited()
    {
        return $this['status'] === self::STATUS_OPEN;
    }
}
