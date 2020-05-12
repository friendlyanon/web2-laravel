<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartnerGroup extends Model
{
    protected $fillable = ['name'];

    protected static $headers = [
        'name' => 'name',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }
}
