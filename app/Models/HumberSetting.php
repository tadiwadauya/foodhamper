<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HumberSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'food_available',
        'meat_available',
        'food_record',
        'meat_record',
        'last_agent',
    ];

    protected $dates = [
        'deleted_at'
    ];
}
