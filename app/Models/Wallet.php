<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets'; // Tên bảng trong database

    protected $fillable = [
        'user_id',
        'balance',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
    ];

    /**
     * Quan hệ với user (một ví thuộc về một user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với các giao dịch của ví.
     */
    public function transactions()
    {
        return $this->hasMany(Wallet_transactions::class);
    }

    /**
     * Cộng tiền vào ví.
     */
    public function deposit($amount)
    {
        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'type' => 'deposit',
            'amount' => $amount,
            'description' => 'Nạp tiền vào ví'
        ]);
    }

    /**
     * Trừ tiền khỏi ví.
     */
    public function withdraw($amount)
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();

            $this->transactions()->create([
                'type' => 'withdrawal',
                'amount' => $amount,
                'description' => 'Rút tiền về tài khoản ngân hàng'
            ]);

            return true;
        }

        return false;
    }
}
