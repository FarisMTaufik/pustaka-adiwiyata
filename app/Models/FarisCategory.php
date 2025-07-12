<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarisCategory extends Model
{
    use HasFactory;

    protected $table = 'faris_categories';

    protected $fillable = ['name', 'theme', 'description'];

    public function books()
    {
        return $this->hasMany(FarisBook::class, 'category_id');
    }
}
