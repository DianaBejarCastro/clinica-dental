<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_branch',
        'city',
        'address',
        'is_active',
    ];
    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }
}
