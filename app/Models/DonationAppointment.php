<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DonationAppointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'donation_id',
        'donation_match_id',
        'appointment_date',
        'appointment_time',
        'location_id',
        'status',
    ];

    /**
     * Get the user (donor) that owns the donation appointment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function donationMatch(): BelongsTo
    {
        return $this->belongsTo(DonationMatch::class, 'donation_match_id');
    }

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
