@extends('layouts.app')
@section('content')
@if( Auth::check() )
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            プロフィール編集
        </div>
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        <!-- 投稿フォーム -->
        @if( Auth::id() == $user->id ) 
          <p>現在の画像</p>
          <img class="img_profile_edit" src="{{ '/profile/'.($user->img_url) }}">
          <form action="{{ url('/mypage/update/'.$user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- サムネイル画像 -->
              <div class="form-group">
                プロフィール画像
                <div class="col-sm-6">
                  <input id="image" type="file" name="img" accept="image/" enctype="multipart/form-data" multiple="multiple" onchange="previewImage(this);">
                </div>
              </div>
              <script>
                function previewImage(obj) {
                  var fr = new FileReader();
                  fr.onload = (function() {
                    document.getElementById('preview').src = fr.result;
                  });
                  fr.readAsDataURL(obj.files[0]);
                  //画像表示
                  var img_profile = document.getElementById('preview');
                  img_profile.classList.add("img_profile_edit");

                  //テキスト表示
                  var text_add = document.getElementById('text_img');
                  text_add.textContent = "新しい画像";
                }
              </script>
              
                <p id="text_img"></p>
                <img id="preview" class="">
              
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
                  <input type="text" name="introduction" class="form-control" value="{{ $user->introduction }}" onchange="previewImage(this)">
                </div>
              </div>
            <!--　登録ボタン -->
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button type="submit" class="btn btn-primary">
                    保存する
                  </button>
                  <a class="btn btn-link pull-right" href="{{ url($user->id.'/post') }}">
                    キャンセル
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