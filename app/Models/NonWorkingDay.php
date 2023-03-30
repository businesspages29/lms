<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonWorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
    ];

    protected $appends = ['date_format'];

    public function getDateFormatAttribute()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }
}
