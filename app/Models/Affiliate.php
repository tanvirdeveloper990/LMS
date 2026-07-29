<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Affiliate extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'affiliate'; // custom guard

    // protected $fillable = [
    //     'fname', 'lname', 'email', 'phone', 'username', 'password',
    //     'website_url', 'social_media_link', 'promotion_method', 'referal_name_id','image', 'status','referal_code'
    // ];

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($affiliate) {

            // সর্বশেষ code বের করা (যেমন: AFF-0021)
            $lastCode = Affiliate::orderBy('id', 'DESC')->value('referal_code');

            if ($lastCode) {
                // "AFF-0021" → "0021"
                $number = intval(substr($lastCode, 4));

                // New code = AFF-(number+1) → padded 4 digits
                $affiliate->referal_code = 'AFF-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);

            } else {
                // প্রথম রেকর্ড হলে AFF-0001
                $affiliate->referal_code = 'AFF-0001';
            }
        });
    }

}
