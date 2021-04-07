<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  <!-- バリデーションエラーの表示に使用-->
  @include('common.errors')
  <!-- バリデーションエラーの表示に使用-->
  <div class="container center-block">
    <div class="row">
      <div class="col-3">{{-- 画像 --}}
        <img class="img_profile float-right" src="{{ '/profile/'.($user->img_url) }}" alt="">
      </div>
      <div class="col-9">{{-- 名前など --}}
        <div class="col-12 text-left">
          {{ $user->name }}<br>
          {{ $user->introduction }}
        </div>
        <div class="col-6 text-left">
          <a href="{{ url('/mypage/followings/'.$user->id) }}">{{ $user->follows()->count() }}フォロー</a>
          <a href="{{ url('/mypage/followers/'.$user->id) }}">{{ $user->followUsers()->count() }}フォロワー</a><br>
        </div>
        <div class="col-6">
          @if(Auth::id() == $user->id)
            <form action="{{ url('/mypage/edit/'.$user->id )}}" method="GET">
              <button type="submit" class="">
                プロフィール編集
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- タブ -->
  <nav class="nav justify-content-center border-bottom">
    <a class="nav-link active" href="{{ url('/mypage/post/'.$user->id) }}">投稿記事</a>
    <a class="nav-link" href="{{ url('/mypage/favorite/'.$user->id) }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url('/mypage/like/'.$user->id) }}">いいね</a>
  </nav>

  <?php $count = 0; ?>
    @foreach ($followings as $follow)
      @if ($loop->index % 3 == 0)
        <div class="container">
          <div class="row">
      @endif
      <div class="container center-block">
        <div class="row">
          
          <div class="col-3">{{-- 画像 --}}
            <a href="{{ url('/mypage/post/'.$follow->id) }}">
              <img class="img_profile float-right" src="{{ '/profile/'.($follow->img_url) }}">
            </a>
          </div>
          <div class="col-6">{{-- 名前など --}}
            <div class="col-12 text-left">
              <h5>{{ $follow->name }}</h5>
            </div>
            <div class="col-6 text-left">
              <a href="{{ url('/mypage/followings/'.$follow->id) }}">{{ $follow->follows()->count() }}フォロー</a>
              <a href="{{ url('/mypage/followers/'.$follow->id) }}">{{ $follow->followUsers()->count() }}フォロワー</a><br>
            </div>
          </div>
          <div class="col-2">
            @if($follow->id == Auth::id())
            <!-- ログインユーザーと表示ユーザーが同じ場合 -->
            <!-- フォロー処理 -->
            @elseif($follow->followUsers()->where('following_user_id',Auth::id())->exists() !== true)
              <form action="{{ url('follow/'.$follow->id) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-secondary">
                  フォローする
                </button>
              </fome>
            <!-- フォロー削除 -->
            @else
              <form action="{{ url('follow_cancel', $follow) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">
                  フォロー中
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
      &nbsp;
    @endforeach
@endsection