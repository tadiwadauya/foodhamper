<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'manager',
        'assistant'
    ];

    public function users()
    {
        return $this->hasMany(User::class,'department_id','id');
    }

}
