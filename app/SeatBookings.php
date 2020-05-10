<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatBookings extends Model
{
    protected $table = 'seat_bookings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'seat_no', 'name', 'email', 'contact_no', 'confirmation_no', 'created_at', 'updated_at'
    ];
}
