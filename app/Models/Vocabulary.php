<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'vocabulary',
        'complexity',
        'form',
        'field',
        'usage_count',
        'success_count',
        'failure_count',
        'updated_at',
        'created_at'
    ];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_answers');
    }
}
