<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Hotel “team members” shown on About / staff admin.
 * Table name is `teams` for historical reasons (avoids clashing with Jetstream’s App\Models\Team).
 */
class StaffMember extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'names',
        'position',
        'description',
        'facebook',
        'twitter',
        'linkedin',
        'image',
        'slug',
    ];
}
