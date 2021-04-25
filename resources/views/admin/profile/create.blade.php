@extends('layouts.profile')
@section('title', 'プロフィール新規作成')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>プロフィール新規作成</h2>
            <form action="{{ action('App\Http\Controllers\Admin\ProfileController@create') }}" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="gender">性別</label>
                    <div class="col-md-10">
                        <input type="radio" name="gender" id="male" value="男性" class="mb-3" checked>
                        <label for="male">男性</label><br>
                        <input type="radio" name="gender" id="female" value="女性">
                        <label for="female">女性</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="hobby">趣味</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="hobby" id="hobby" rows="10">{{ old('hobby') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="introduce">自己紹介</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="introduce" id="introduce" rows="20">{{ old('introduction') }}</textarea>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="col-md-10 ml-5">
                    <input type="submit" class="btn btn-primary mr-3" value="新規作成">
                    <input type="reset" value="リセット" class="btn btn-light">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection