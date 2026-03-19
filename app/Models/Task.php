<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        "name",
        "finished_at",
        "started_at",
    ];
    protected $casts = [
        "finished_at" => "datetime",
        "started_at" => "datetime",
    ];
}
