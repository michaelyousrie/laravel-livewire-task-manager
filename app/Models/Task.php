<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'priority', 'body', 'project', 'is_done'
    ];
}
