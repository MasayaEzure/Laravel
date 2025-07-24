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
        'title' => 'required',
        'body' => 'required',
    );

    // Newsモデルのリレーションを設定
    public function histories()
    {
        // フォルダ名\ファイル名とし、今回はHistoryモデルを指定
        return $this->hasMany('App\Models\History');
    }
}
