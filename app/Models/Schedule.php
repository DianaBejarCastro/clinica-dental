<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'break',
        'start_break',
        'end_break',
        'is_active',
        'dentist_id',
    ];

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }
}
