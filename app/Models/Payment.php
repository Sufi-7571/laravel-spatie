<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_session_id',
        'amount',
        'currency',
        'product_name',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
