<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
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

    // 管理者権限チェック用スコープ
    public function scopeAdminAccessible($query)
    {
        // 管理者は全レコードにアクセス可能
        return $query;
    }
    
    // IDの妥当性チェック
    public static function findOrFailSecure($id)
    {
        if (!$id || !is_numeric($id) || $id <= 0) {
            abort(400, 'Invalid ID parameter');
        }
        
        return static::findOrFail($id);
    }
}