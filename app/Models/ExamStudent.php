<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamStudent extends Model
{
    protected $fillable = [
        'full_name',
        'student_code',
        'class_name',
        'reference',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];
}
