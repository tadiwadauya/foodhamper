<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usertype extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class,'usertype_id','id');
    }

}
