@extends('layouts.admin')
@section('title', 'プロフィール一覧画面')

@section('content')
<div class="container">
    <div class="row">
        <h2>プロフィール一覧</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ action('App\Http\Controllers\Admin\ProfileController@add')}}" class="btn btn-primary" role="button">
                新規作成
            </a>
        </div>
        <div class="col-md-8">
            <form action="{{ action('App\Http\Controllers\Admin\ProfileController@show')}}" method="get">
                <div class="form-group row">
                    <label for="name" class="col-md-8">名前</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
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
        <div class="admin-profile col-md-12 mx-auto">
            <div class="row">
                <table class="table-dark table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">名前</th>
                            <th width="10%">性別</th>
                            <th width="20%">趣味</th>
                            <th width="30%">自己紹介</th>
                            <th width="15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts_profile as $profile)
                        <tr>
                            <th>{{ $profile->id }}</th>
                            <td>{{ Str::limit($profile->name, 40)}}</td>
                            <td>{{ Str::limit($profile->gender, 5)}}</td>
                            <td>{{ Str::limit($profile->hobby, 60)}}</td>
                            <td>{{ Str::limit($profile->introduce, 100)}}</td>
                            <td class="edit-button">
                                <a href="{{ action('App\Http\Controllers\Admin\ProfileController@edit', ['id' => $profile->id]) }}">
                                    編集
                                </a>
                            </td>
                            <td class="delete-button">
                                <a href="{{ action('App\Http\Controllers\Admin\ProfileController@delete', ['id' => $profile->id]) }}">
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