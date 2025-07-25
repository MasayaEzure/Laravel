<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\History;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function add()
    {
        // 'admin/news/create'にアクセス
        return view('admin.news.create');
    }

    public function create(Request $request)
    {
        // バリデーションを実行
        // 'admin/news/create'にリダイレクト
        $this->validate($request, News::$rules);

        $news = new News;
        $form = $request->all();

        // 画像が添付されたらパスに画像を保存する
        if (isset($form['image'])) {
            $image = $request->file('image');
            
            // ファイル検証
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 20 * 1024 * 1024; // 20MB
            
            // 拡張子チェック
            $extension = strtolower($image->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return back()->withErrors(['image' => '許可されていないファイル形式です。JPG, PNG, GIF, WEBPのみ可能です。']);
            }
            
            // MIMEタイプチェック
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return back()->withErrors(['image' => '不正なファイル形式です。']);
            }
            
            // ファイルサイズチェック
            if ($image->getSize() > $maxFileSize) {
                return back()->withErrors(['image' => 'ファイルサイズが大きすぎます。20MB以下にしてください。']);
            }
            
            $path = $image->store('public/image');
            $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }

        // フォームからのトークンを削除
        unset($form['_token']);
        // フォームからの画像を削除
        unset($form['image']);

        // データベースにフォームの内容を保存
        $news->fill($form)->save();

        return redirect('admin/news');
    }

    // ニュース一覧を表示するためのアクション
    public function index(Request $request)
    {
        // 検索入力の検証
        $request->validate([
            'cond_title' => 'nullable|string|max:255|regex:/^[\p{L}\p{N}\s\-_]+$/u'
        ]);
        
        // Viewで検索されたタイトルを代入
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたタイトルと一致するレコードを取得する（LIKEクエリに変更）
            $posts = News::where('title', 'LIKE', '%' . $cond_title . '%')->get();
        } else {
            // 全てのニュースを取得
            $posts = News::all();
        }

        return view('admin.news.index', [
            // 取得されたレコード
            'posts' => $posts,
            // 検索されたタイトル
            'cond_title' => $cond_title
        ]);
    }

    // 編集するためのアクション
    public function edit(Request $request)
    {
        // 管理者権限とIDの妥当性を確認
        if (!$request->id || !is_numeric($request->id)) {
            abort(400, 'Invalid ID parameter');
        }
        
        // findメソッドで該当idのNewsモデルを取得
        $news = News::find($request->id);
        if (empty($news)) {
            // エラー系のレスポンスを返す
            abort(404, 'News record not found');
        }
        
        return view('admin.news.edit', ['news_form' => $news]);
    }

    // 更新するためのアクション
    public function update(Request $request)
    {
        // IDの妥当性を確認
        $id = $request->input('id');
        if (!$id || !is_numeric($id)) {
            abort(400, 'Invalid ID parameter');
        }
        
        $this->validate($request, News::$rules);
        $news = News::find($id);
        
        if (!$news) {
            abort(404, 'News record not found');
        }
        // フォームから送信されたデータを格納
        $news_form = $request->all();

        // 添付された画像の処理
        if ($request->input('remove')) {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $image = $request->file('image');
            
            // ファイル検証
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 20 * 1024 * 1024; // 20MB
            
            // 拡張子チェック
            $extension = strtolower($image->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return back()->withErrors(['image' => '許可されていないファイル形式です。JPG, PNG, GIF, WEBPのみ可能です。']);
            }
            
            // MIMEタイプチェック
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return back()->withErrors(['image' => '不正なファイル形式です。']);
            }
            
            // ファイルサイズチェック
            if ($image->getSize() > $maxFileSize) {
                return back()->withErrors(['image' => 'ファイルサイズが大きすぎます。20MB以下にしてください。']);
            }
            
            $path = $image->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        // フォームからのトークンを削除
        unset($news_form['_token']);
        // フォームから送信された画像を削除
        unset($news_form['image']);
        // フォームでの削除処理を削除
        unset($news_form['remove']);

        $news->fill($news_form)->save();

        // Historyモデルのインスタンス化
        $history = new History;
        // Historyモデルのnews_idを$newsクラスのidに格納
        $history->news_id = $news->id;
        // Histroyモデルのedited_atは現在時間を取得
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news');
    }

    public function delete(Request $request)
    {
        // IDの妥当性を確認
        if (!$request->id || !is_numeric($request->id)) {
            abort(400, 'Invalid ID parameter');
        }
        
        // 該当idのNewsモデルを取得
        $news = News::find($request->id);
        
        if (!$news) {
            abort(404, 'News record not found');
        }
        
        $news->delete();

        return redirect('admin/news');
    }
}