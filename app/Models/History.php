<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'news_id',
        'edited_at'
    ];

    public static $rules = array(
        'news_id' => 'required',
        'edited_at' => 'required',
    );
}
