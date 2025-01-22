<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'monthly_price',
        'age',
        'phone_no',
        'email',
        'total_due_left',
        'joined_date',
    ];
}
