<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'type',
        'slot',
        'date',
        'time',
    ];

    public function scopeNotId($query,$id): void
    {
        $query->where('id','!=', $id);
    }

    public function scopeType($query,$type): void
    {
        $query->where('type','=', $type);
    }

    public function scopeSlot($query,$slot): void
    {
        $query->where('slot','=', $slot);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
