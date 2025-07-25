<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History_profile extends Model
{
    protected $fillable = [
        'profile_id',
        'edited_at'
    ];

    public static $rules = array(
        'profile_id' => 'required',
        'edited_at' => 'required',
    );
}
