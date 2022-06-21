<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Termination extends Model
{
    use HasFactory;

    protected $table= 'terminations';

    protected $fillable = [
        'paynumber',
        'department',
        'first_name',
        'last_name',
        'reason'
    ];
}
