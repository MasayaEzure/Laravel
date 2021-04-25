<!-- テンプレートの継承 -->
@extends('layouts.admin')
<!-- @yield('title')に埋め込む内容 -->
@section('title', '新規作成ページ')

<!-- @yield('content')に以下のタグを埋め込む -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>ニュース新規作成</h2>
            <form action="{{ action('App\Http\Controllers\Admin\NewsController@create')}}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="body" class="col-md-2">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">
                        {{ old('body') }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-2">画像</label>
                    <div class="col-md-10">
                        <input type="file" class="for-control-file" name="image">
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="col-md-10">
                    <input type="submit" class="btn btn-primary" value="新規作成">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection