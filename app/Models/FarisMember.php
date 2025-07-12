<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Import model User bawaan Laravel

class FarisMember extends Model
{
    use HasFactory;

    protected $table = 'faris_members'; // Sesuaikan dengan prefix Anda

    protected $fillable = [
        'user_id', 'member_id_number', 'address', 'phone_number', 'role', 'total_points'
    ];

    /**
     * Relasi: Satu anggota dimiliki oleh satu user (dari tabel users bawaan Laravel).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Satu anggota bisa memiliki banyak peminjaman.
     */
    public function borrowings()
    {
        return $this->hasMany(FarisBorrowing::class, 'member_id');
    }

    /**
     * Relasi: Satu anggota bisa memiliki banyak poin literasi.
     */
    public function literacyPoints()
    {
        return $this->hasMany(FarisLiteracyPoint::class, 'member_id');
    }

    /**
     * Relasi: Satu anggota bisa memiliki banyak ulasan.
     */
    public function reviews()
    {
        return $this->hasMany(FarisReview::class, 'member_id');
    }

    /**
     * Relasi: Satu anggota bisa memiliki banyak reservasi.
     */
    public function reservations()
    {
        return $this->hasMany(FarisReservation::class, 'member_id');
    }
}
