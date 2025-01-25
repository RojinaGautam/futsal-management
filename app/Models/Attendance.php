<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';

    protected $fillable = [
        'academy_member_id',
        'attendance_date',
        'status',
    ];

    public function academyMember()
    {
        return $this->belongsTo(Academy::class, 'academy_member_id');
    }

}