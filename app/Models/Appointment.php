<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'status',
        'center_id',
        'dentist_id',
        'user_id',
    ];

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
