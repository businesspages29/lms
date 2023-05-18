<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'logo',
        'name',
        'email',
        'website',
    ];

    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
        if(!empty($this->logo)){
            return Storage::disk('public')->url("logos/".$this->logo);
        }
        return asset('product.jpg');
    }

    public function employees(): HasMany
    {
        return $this->HasMany(Employee::class);
    }    
}
