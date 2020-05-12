<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'city',
        'address',
        'zip_code',
        'partner_group_id',
    ];

    protected static $headers = [
        'id' => 'id',
        'name' => 'name',
        'zip_code' => 'zip_code',
        'city' => 'city',
        'address' => 'address',
        'partner_group' => 'partner_group.name',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function partnerGroup(): BelongsTo
    {
        return $this->belongsTo(PartnerGroup::class);
    }
}
