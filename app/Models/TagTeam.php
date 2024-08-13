<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'category_id',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }
}
