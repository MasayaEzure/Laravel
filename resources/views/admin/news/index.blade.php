@extends('layouts.admin')
@section('title', 'ニュース一覧画面')

@section('content')
<div class="container">
    <div class="row">
        <h2>ニュース一覧</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ action('App\Http\Controllers\Admin\NewsController@add')}}" class="btn btn-primary" role="button">
                新規作成
            </a>
        </div>
        <div class="col-md-8">
            <form action="{{ action('App\Http\Controllers\Admin\NewsController@index')}}" method="get">
                <div class="form-group row">
                    <label for="title" class="col-md-2">タイトル</label>
                    <div class="col-md-8">
                        <input type="text" id="title" class="form-control" name="cond_title" value="{{ $cond_title }}">
                    </div>
                    <div class="col-md-2">
                        {{ csrf_field() }}
                        <input type="submit" class="btn-primary" value="検索">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="admin-news col-md-12 mx-auto">
            <div class="row">
                <table class="table-dark table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="20%">タイトル</th>
                            <th width="50%">本文</th>
                            <th width="10%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $news)
                        <tr>
                            <th>{{ $news->id }}</th>
                            <!-- タイトルが全て全角なら50文字以内で表示 -->
                            <td>{{ Str::limit($news->title, 100)}}</td>
                            <!-- 本文が全て全角なら125文字以内で表示 -->
                            <td>{{ Str::limit($news->body, 250)}}</td>
                            <td class="edit-button">
                                <a href="{{ action('App\Http\Controllers\Admin\NewsController@edit', ['id' => $news->id]) }}">
                                    編集
                                </a>
                            </td>
                            <td class="delete-button">
                                <a href="{{ action('App\Http\Controllers\Admin\NewsController@delete', ['id' => $news->id]) }}">
                                    削除
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection