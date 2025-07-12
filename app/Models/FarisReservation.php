<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarisReservation extends Model
{
    use HasFactory;

    protected $table = 'faris_reservations';

    protected $fillable = [
        'book_id', 'member_id', 'reservation_date', 'expiration_date', 'status'
    ];

    public function book()
    {
        return $this->belongsTo(FarisBook::class, 'book_id');
    }

    public function member()
    {
        return $this->belongsTo(FarisMember::class, 'member_id');
    }
}
