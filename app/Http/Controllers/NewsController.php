<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // 検索入力の検証
        $request->validate([
            'cond_title' => 'nullable|string|max:255|regex:/^[\p{L}\p{N}\s\-_]+$/u'
        ]);
        
        $cond_title = $request->cond_title;

        if ($cond_title != '') {
            // タイトルで記事を検索し、該当するものを取得（LIKEクエリに変更）
            $posts = News::where('title', 'LIKE', '%' . $cond_title . '%')->orderBy('updated_at', 'desc')->get();
        } else {
            // 新規投稿順に並び替える
            $posts = News::all()->sortByDesc('updated_at');
        }

        if (count($posts) > 0) {
            // 最新の記事を$headlineに代入
            // $postsに過去記事を格納
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        return view('news.index', [
            'headline' => $headline, 
            'posts' => $posts,
            'cond_title' => $cond_title
            ]);
    }
}
