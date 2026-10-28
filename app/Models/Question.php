<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'service_slug', 'name', 'email', 'subject', 'body', 'answer', 'status', 'approved_at',
    ];

    protected function casts(): array
    {
        return ['approved_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::saving(function (Question $question): void {
            $question->approved_at = $question->status === 'approved' && filled($question->answer) ? now() : null;
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')->whereNotNull('answer');
    }
}
