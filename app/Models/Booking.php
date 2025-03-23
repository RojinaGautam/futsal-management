<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'booking_time',
        'booking_name',
        'phone_number',
        'total_amount_paid',
        'del_flg'
    ];

    protected $casts = [
        'booking_date' => 'date:Y-m-d',
        'booking_time' => 'string',
        'total_amount_paid' => 'decimal:2',
        'del_flg' => 'boolean'
    ];
}