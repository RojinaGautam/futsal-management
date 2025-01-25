<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;
    
    protected $table = 'academy';

    protected $fillable = [
        'student_name',
        'monthly_price',
        'age',
        'phone_no',
        'email',
        'total_due_left',
        'joined_date',
        'is_scholar', 
        'is_regular', 
        'payment_history',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'academy_member_id');
    }

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
