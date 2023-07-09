<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'player_id',
        'creation_type',
        'duration_in_seconds',
        'start_time',
        'end_time',
        'result',
        'updated_at',
        'created_at'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function vocabularies()
    {
        return $this->belongsToMany(Vocabulary::class, 'quiz_answers');
    }
}
