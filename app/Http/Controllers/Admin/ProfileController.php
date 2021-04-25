<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\History_profile;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        // バリデーションを実行
        $this->validate($request, Profile::$rules_profile);

        $profile = new Profile();
        $form = $request->all();

        unset($form['_token']);

        $profile->fill($form)->save();

        return redirect('admin/profile');
    }

    // プロフィール一覧を表示させるアクション
    public function show(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            // 名前を検索したら一致するレコードを取得
            $posts_profile = Profile::where('name', $cond_name)->get();
        } else {
            // 全てのプロフィールを取得
            $posts_profile = Profile::all();
        }

        return view('admin.profile.index', [
            'posts_profile' => $posts_profile,
            'cond_name' => $cond_name
        ]);
    }

    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules_profile);

        $profile = Profile::find($request->input('id'));
        $profile_form = $request->all();
        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();

        $history_profile = new History_profile;
        $history_profile->profile_id = $profile->id;
        $history_profile->edited_at = Carbon::now();
        $history_profile->save();
        
        return redirect('admin/profile');
    }

    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();

        return redirect('admin/profile');
    }
}
