<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'category_id',
        'includes_inactive',
    ];

    /**
     * Get the category that owns the ranking.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
