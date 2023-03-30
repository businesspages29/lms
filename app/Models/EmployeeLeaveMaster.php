<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_master_id',
        'from_date',
        'to_date',
        'number_of_days',
        'comment',
    ];

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }
}
