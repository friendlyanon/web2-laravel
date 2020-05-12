<?php

namespace App;

use App\Utils\HasEditCheck;
use App\Utils\HasTableHeaders;
use Hash;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/** @property-read bool $is_superadmin */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasTableHeaders;
    use HasEditCheck;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['email_verified_at'];

    protected $casts = ['is_admin' => 'boolean'];

    protected static $headers = [
        'name' => 'name',
        'email' => 'email',
        'is_admin' => 'is_admin',
    ];

    public function getIsSuperadminAttribute(): bool
    {
        return $this['id'] === 1;
    }

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    public static function boot()
    {
        parent::boot();

        // Can't delete superadmin
        static::deleting(static fn(User $user) => ! $user->is_superadmin);

        // Only superadmin can edit superadmin details
        static::saving(static function (User $user) {
            if ($user['id'] !== 1) {
                return true;
            }

            return \Auth::id() === 1;
        });
    }
}
