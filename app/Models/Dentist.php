<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci',
        'day_of_birth',
        'address',
        'phone',
        'is_active',
        'user_id',
        'center_id',
    ];

    /**
     * Get the user associated with the dentist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the center associated with the dentist.
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'dentist_specialty', 'dentist_id', 'specialty_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    /**
     * Get the work schedules for the dentist.
     */
}