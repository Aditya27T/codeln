<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'code_template',
        'test_cases',
        'solution',
    ];

    protected $casts = [
        'test_cases' => 'array',
    ];

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }
}