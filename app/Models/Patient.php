<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification_number',
        'identification_type',
        'gender',
        'date_of_birth',
        'address',
        'phone',
        'image',
        'user_id',
        'center_id',
    ];

    /**
     * Get the user that owns the patient.
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }
}