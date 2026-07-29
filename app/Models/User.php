<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
// class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            // সর্বশেষ code বের করা (যেমন: AFF-0021)
            $lastCode = User::orderBy('id', 'DESC')->value('referal_code');

            if ($lastCode) {
                // "AFF-0021" → "0021"
                $number = intval(substr($lastCode, 4));

                // New code = AFF-(number+1) → padded 4 digits
                $user->referal_code = 'AUFF-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);

            } else {
                // প্রথম রেকর্ড হলে AFF-0001
                $user->referal_code = 'AUFF-0001';
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    
    // app/Models/User.php

public function orders()
{
    return $this->hasMany(\App\Models\Order::class, 'user_id');
}

public function wishlists()
{
    return $this->hasMany(\App\Models\Wishlist::class, 'user_id');
}

}
