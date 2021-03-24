@extends('layouts.app')
@section('content')
@if( Auth::check() )
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            プロフィール
        </div>
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        <!-- 投稿フォーム -->
        @if( Auth::id() == $user->id ) 
          <form action="{{ url($user->id.'/update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- サムネイル画像 -->
              <div class="form-group">
                プロフィール画像
                <div class="col-sm-6">
                  <input type="file" name="img_url" accept="image/png, image/jpeg" value="{{ Storage::url($user->img_url) }}">
                </div>
              </div>
            <!-- 投稿のタイトル -->
              <div class="form-group">
                名前
                <div class="col-sm-6">
                  <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>
              </div>
            <!-- 投稿の本文 -->
              <div class="form-group">
                説明文（255文字）
                <div class="col-sm-6">
                  <input type="text" name="introduction" class="form-control" value="{{ $user->introduction }}">
                </div>
              </div>
            <!--　登録ボタン -->
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button type="submit" class="btn btn-primary">
                    Save
                  </button>
                  <a class="btn btn-link pull-right" href="{{ url('/home') }}">
                    back
                  </a>
                </div>
              </div>
            <input type="hidden" name="id" value="{{ $user->id }}" >
          </form>
        <!-- /投稿フォーム -->
        @endif
    </div>
@endif
@endsection