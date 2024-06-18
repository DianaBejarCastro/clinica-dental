<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci', // Agrega 'ci' al array $fillable
        'day_of_birth',
        'address',
        'phone',
        'center_id',
        'user_id',
        'is_active',
    ];
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
