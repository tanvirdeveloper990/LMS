<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionEarn extends Model
{
    protected $fillable = [
        'affiliate_id', 'level_id', 'amount', 'total_sales', 'percentage', 'status'
    ];

    public function level()
    {
        return $this->belongsTo(CommissionLevel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'affiliate_id', 'referal_code');
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'referal_code');
    }


}
