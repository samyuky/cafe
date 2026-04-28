<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'queue_number',
        'subtotal',
        'tax_amount',
        'total_amount',
        'payment_amount',
        'change_amount',
        'payment_method',
        'transaction_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    
    // Generate nomor antrian otomatis
    public static function generateQueueNumber()
    {
        $today = today();
        $lastTransaction = self::whereDate('created_at', $today)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastTransaction && $lastTransaction->queue_number) {
            $lastNumber = (int) substr($lastTransaction->queue_number, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'Q-' . $today->format('dmy') . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}