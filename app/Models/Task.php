<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'priority', 'body', 'project', 'is_done', 'done_at'
    ];

    protected function casts()
    {
        return [
            'done_at' => 'datetime'
        ];
    }
}
