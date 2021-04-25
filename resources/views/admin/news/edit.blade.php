@extends('layouts.admin')
@section('title', 'ニュース編集画面')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>ニュース編集</h2>
            <form action="{{ action('App\Http\Controllers\Admin\NewsController@update')}}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li style="color: red;">{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label for="title" class="col-md-2">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" id="title" class="form-control" name="title" value="{{ $news_form->title }}">
                    </div>
                </div>
                <div class="form-group row">
                    <lable class="col-md-2" for="body">本文</lable>
                    <div class="col-md-10">
                        <textarea name="body" id="body" rows="20" class="form-control">{{ $news_form->body }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-md-2">画像</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="image" id="image">
                        <div class="form-text text-info">
                            設定中：{{ $news_form->image_path }}
                        </div>
                        <div class="form-check">
                            <label for="remove" class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="remove" id="remove" value="true">
                                画像を削除
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $news_form->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>
            </form>
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <h2>編集履歴</h2>
                    <ul class="list-group">
                        @if($news_form->histories != NULL)
                        @foreach($news_form->histories as $history)
                        <li class="list-group-item">{{ $history->edited_at }}</li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection