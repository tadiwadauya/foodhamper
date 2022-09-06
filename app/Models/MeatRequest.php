<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeatRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'paynumber',
        'department',
        'name',
        'allocation',
        'done_by',
        'status',
        'trash',
        'reason',
        'type',
        'request',
        'jobcard'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'paynumber', 'paynumber');
    }

    public function allocation()
    {
        return $this->belongsTo(Allocation::class);
    }

    public function approve()
    {
        return $this->hasOne(User::class, 'paynumber', 'approver');
    }

    public function job()
    {
        return $this->belongsTo(Jobcard::class, 'jobcard', 'card_number');
    }
}
