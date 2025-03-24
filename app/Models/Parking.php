<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parkings';

    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'monthly_price',
        'total_due',
        'payment_history',
    ];

    public function addPaymentHistory($amount, $date)
    {
        $paymentHistory = $this->payment_history ? json_decode($this->payment_history, true) : [];
        $paymentHistory[] = [
            'amount' => $amount,
            'date' => $date,
        ];
        $this->payment_history = json_encode($paymentHistory);
        $this->save();
    }
}