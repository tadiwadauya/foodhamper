<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeatCollection extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates =  [
        'deleted_at'
    ];

    protected $fillable = [
        'paynumber',
        'jobcard',
        'issue_date',
        'allocation',
        'mrequest',
        'done_by',
        'status',
        'collected_by',
        'id_number',
        'self'
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation', 'allocation');
    }

    public function frequest()
    {
        return $this->belongsTo(FoodRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'paynumber', 'paynumber');
    }

    public function job()
    {
        return $this->belongsTo(Jobcard::class, 'jobcard', 'card_number');
    }
}
