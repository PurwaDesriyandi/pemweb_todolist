<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
    ];

=======
    protected $fillable = ['title', 'description', 'status', 'deadline'];
>>>>>>> 29c6d9275264bfafedb2897ee471d1c5308346f3
}
