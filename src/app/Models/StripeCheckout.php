<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeCheckout extends Model
{
    protected $fillable = [
        'session_id',
        'item_id',
        'buyer_id',
        'status',
    ];
}

