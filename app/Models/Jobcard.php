<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobcard extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'card_number',
        'date_opened',
        'card_month',
        'card_type',
        'quantity',
        'issued',
        'remaining',
        'extras_previous',
        'temp'
    ];

    public function fcollections()
    {
        return $this->hasMany(FoodCollection::class,'jobcard','card_number');
    }

    public function frequests()
    {
        return $this->hasMany(FoodRequest::class,'jobcard','card_number');
    }

    public function mcollections()
    {
        return $this->hasMany(MeatCollection::class,'jobcard','card_number');
    }
}
