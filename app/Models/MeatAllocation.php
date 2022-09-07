<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeatAllocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'paynumber',
        'meat_allocation',
        'meat_a',
        'meat_b',
        'meatallocation',
        'status'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'paynumber','paynumber');
    }

    public function mcollection()
    {
        return $this->hasOne(MeatCollection::class,'meatallocation','meatallocation');
    }

    public function frequest()
    {
        return $this->hasMany(MeatRequest::class);
    }

}
