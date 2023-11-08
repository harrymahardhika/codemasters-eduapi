<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'code',
        'credits',
        'instructor',
        'department',
        'location',
        'enrollment_limit',
        'fee',
    ];

    protected $casts = [
        'fee' => 'float',
    ];
}
