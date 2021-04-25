<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $id = array('id');
    protected $fillable = [
        'name',
        'gender',
        'hobby',
        'introduce'
    ];

    public static $rules_profile = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduce' => 'required',
    );

    public function histories_profile()
    {
        return $this->hasMany('App\Models\History_profile');
    }
}