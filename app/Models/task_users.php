<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class task_users extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
    ];

    public function task(){
        return $this->belongsTo(task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
