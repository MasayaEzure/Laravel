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
}
