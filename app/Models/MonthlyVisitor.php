<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'unique_visitors',
    ];

    protected $dates = [
        'month',
    ];
}
