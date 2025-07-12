<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarisBorrowing extends Model
{
    use HasFactory;

    protected $table = 'faris_borrowings';

    protected $fillable = [
        'book_id', 'member_id', 'borrow_date', 'due_date', 'return_date', 'fine_amount', 'status'
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
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
