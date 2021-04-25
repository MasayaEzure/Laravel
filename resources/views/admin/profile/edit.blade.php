@extends('layouts.admin')
@section('title', 'プロフィール編集画面')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>プロフィール編集</h2>
            <form action="{{ action('App\Http\Controllers\Admin\ProfileController@update') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li style="color: red;">{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2" for="name">名前</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="name" id="name" value="{{ $profile_form->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="gender">性別</label>
                    <div class="col-md-10">
                        <input type="radio" name="gender" id="male" value="男性" class="mb-3" {{ $profile_form->gender == "男性" ? "checked" : "" }}>
                        <label for="male">男性</label><br>
                        <input type="radio" name="gender" id="female" value="女性" {{ $profile_form->gender == "女性" ? "checked" : "" }}>
                        <label for="female">女性</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="hobby">趣味</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="hobby" id="hobby" rows="10">{{ $profile_form->hobby }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="introduce">自己紹介</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="introduce" id="introduce" rows="20">{{ $profile_form->introduce }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value=" {{ $profile_form->id }} "> {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary mr-3" value="更新">
                    </div>
                </div>
            </form>
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <h2>編集履歴</h2>
                    <ul class="list-group">
                        @if($profile_form->histories_profile != NULL)
                        @foreach($profile_form->histories_profile as $history_profile)
                        <li class="list-group-item">{{ $history_profile->edited_at }}</li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection