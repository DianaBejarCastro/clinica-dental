<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'patient_id',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
