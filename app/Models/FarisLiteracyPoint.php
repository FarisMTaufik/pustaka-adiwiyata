<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarisLiteracyPoint extends Model
{
    use HasFactory;

    protected $table = 'faris_literacy_points';

    protected $fillable = [
        'member_id', 'activity_type', 'points', 'reference_id', 'description'
    ];

    public function member()
    {
        return $this->belongsTo(FarisMember::class, 'member_id');
    }
}
