<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    public const RESOURCES = [
        'discounts',
        'invoices',
        'partners',
        'partnerGroups',
        'products',
        'taxes',
    ];

    protected $fillable = [
        'name',
        'address',
        'bank_account',
        'bank_number',
        'city',
        'country',
        'email',
        'fax',
        'iban',
        'phone',
        'swift',
        'zip_code',
        'tax_number',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function partnerGroups(): HasMany
    {
        return $this->hasMany(PartnerGroup::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function taxes(): HasMany
    {
        return $this->hasMany(Tax::class);
    }
}
