<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
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

    protected static $headers = [
        'name' => 'name',
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

    public static function boot()
    {
        parent::boot();

        static::created(static function (Organization $model) {
            $model->partnerGroups()->createMany([
                ['name' => 'aktuális előfizetők'],
                ['name' => 'állandó tagok'],
                ['name' => 'ingyenes csoport'],
                ['name' => 'inaktív csoport'],
            ]);
        });
    }
}
