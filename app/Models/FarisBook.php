<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarisBook extends Model
{
    use HasFactory;

    protected $table = 'faris_books';

    protected $fillable = [
        'title', 'author', 'isbn', 'publication_year', 'quantity',
        'available_quantity', 'category_id', 'theme', 'description', 'cover_image'
    ];

    public function category()
    {
        return $this->belongsTo(FarisCategory::class, 'category_id');
    }

    public function borrowings()
    {
        return $this->hasMany(FarisBorrowing::class, 'book_id');
    }

    public function reviews()
    {
        return $this->hasMany(FarisReview::class, 'book_id');
    }

    public function reservations()
    {
        return $this->hasMany(FarisReservation::class, 'book_id');
    }
}
