<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    use HasFactory;

    protected $table = 'terms_conditions';

    protected $fillable = [
        'content',
        'status',
        'updated_by',
    ];

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
