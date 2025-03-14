<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet_transactions extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'description',
        'created_at'
    ];

    /**
     * Quan hệ với ví (mỗi giao dịch thuộc về một ví).
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
