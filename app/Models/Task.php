<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority', 'body', 'project', 'is_done', 'done_at'
    ];

    protected function casts()
    {
        return [
            'done_at' => 'datetime'
        ];
    }

    public function isDone(): bool
    {
        return $this->done_at !== null;
    }
}
