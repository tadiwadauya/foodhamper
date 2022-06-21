<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryPassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'paynumber',
        'pin'
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class,'id_number','id_number');
    }
}
