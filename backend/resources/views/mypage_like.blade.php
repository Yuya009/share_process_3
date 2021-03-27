<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  <!-- バリデーションエラーの表示に使用-->
  @include('common.errors')
  <!-- バリデーションエラーの表示に使用-->
  <!-- ログイン者情報 -->
  <div class="justify-content-center">
    名前：{{ $user->name }}<br>
    <a href="{{ url($user->id.'/followings') }}">{{ $user->follows()->count() }}フォロー</a><br>
    <a href="{{ url($user->id.'/followers') }}">{{ $user->followUsers()->count() }}フォロワー</a><br>
    @if(Auth::id() == $user->id)
      <form action="{{ url($user->id.'/profile_edit') }}" method="GET">
        {{ csrf_field() }}
        <button type="submit" class="">
          プロフィール編集
        </button>
      </form>
      @endif
  </div>
  <!-- /ログイン者情報 -->
  <!-- タブ -->
  <nav class="nav justify-content-center">
    <a class="nav-link active" href="{{ url($user->id.'/post') }}">投稿記事</a>
    <a class="nav-link" href="{{ url($user->id.'/favorite') }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url($user->id.'/like') }}">いいね</a>
  </nav>
  <!-- /タブ -->
  <div class="card-body">
    <div class="card-body">
      <table class="table table-striped task-table">
        <!-- テーブルヘッダ -->
        <table class="table table-striped task-table">
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