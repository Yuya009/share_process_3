<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  <!-- バリデーションエラーの表示に使用-->
  @include('common.errors')
  <!-- バリデーションエラーの表示に使用-->
  <!-- ログイン者情報 -->
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
            <form action="{{ url('/mypage/edit/'.$user->id)}}" method="GET">
              <button type="submit" class="">
                プロフィール編集
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- /ログイン者情報 -->
  <!-- タブ -->
  <nav class="nav justify-content-center">
    <a class="nav-link active" href="{{ url('/mypage/post/'.$user->id) }}">投稿記事</a>
    <a class="nav-link" href="{{ url('/mypage/favorite/'.$user->id) }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url('/mypage/like/'.$user->id) }}">いいね</a>
  </nav>
  <!-- /タブ -->
  <div class="card-body">
    <div class="card-body">
      <table class="table table-striped task-table">
        <!-- テーブルヘッダ -->
          <thead>
            <th>いいね一覧</th>
            <th>&nbsp;</th>
          </thead>
          <!-- テーブル本体 -->
          <tbody>
            @foreach ($like_posts as $like_post)
            <tr>
              <!-- 投稿タイトル -->
              <td class="table-text">
                <div>{{ $like_post->post_title }}</div>
              </td>
              <!-- 投稿詳細 -->
              <td class="table-text">
                <div>{{ $like_post->post_desc }}</div>
              </td>
              <!-- 投稿者名の表示 -->
              <td class="table-text">
                <div>{{ $like_post->user->name }}</div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
@endsection