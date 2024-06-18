<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistSpecialty extends Model
{
    use HasFactory;
  /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dentist_id',
        'specialty_id',
    ];

    /**
     * Get the dentist associated with the specialty.
     */
    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    /**
     * Get the specialty associated with the dentist.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}