<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'body',
        'image_path'
    ];

    public static $rules = array(
        'title' => 'required|max:250',
        'body' => 'required|max:10000',
        'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:20480', // 20MB
    );

    // Newsモデルのリレーションを設定
    public function histories()
    {
        // フォルダ名\ファイル名とし、今回はHistoryモデルを指定
        return $this->hasMany('App\Models\History');
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
