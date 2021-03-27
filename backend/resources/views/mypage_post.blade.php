<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  <!-- バリデーションエラーの表示に使用-->
  @include('common.errors')

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
          <a href="{{ url($user->id.'/followings') }}">{{ $user->follows()->count() }}フォロー</a>
          <a href="{{ url($user->id.'/followers') }}">{{ $user->followUsers()->count() }}フォロワー</a><br>
        </div>
        <div class="col-6">
          @if(Auth::id() == $user->id)
            <form action="{{ url($user->id.'/profile_edit')}}" method="GET">
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
  <nav class="nav justify-content-center">
    <a class="nav-link active" href="{{ url($user->id.'/post') }}">投稿記事</a>
    <a class="nav-link" href="{{ url($user->id.'/favorite') }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url($user->id.'/like') }}">いいね</a>
  </nav>

  <!-- 全ての投稿リスト -->
      <div class="card-body">
        <div class="card-body">
          <table class="table table-striped task-table">
            <!-- テーブルヘッダ -->
            <thead>
              <th>投稿記事一覧</th>
              <th>&nbsp;</th>
            </thead>
            <!-- テーブル本体 -->
            <tbody>
              @foreach ($posts as $post)
                  <tr>
                    <!-- 投稿タイトル -->
                    <td class="table-text">
                      <div>{{ $post->post_title }}</div>
                    </td>
                    <!-- 投稿詳細 -->
                    <td class="table-text">
                      <div>{{ $post->post_desc }}</div>
                    </td>
                    <!-- 投稿者名の表示 -->
                    <td class="table-text">
                      <div>{{ $post->user->name }}</div>
                    </td>
                    <!-- お気に入りボタン -->
                    <td class="table-text">
                      @if(Auth::check())
                        @if(Auth::id() != $post->user_id && $post->favo_user()->where('user_id',Auth::id())->exists() !== true)
                          <form action="{{ url('post/'.$post->id) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                            お気に入り
                            </button>
                          </form>
                        @endif
                      @endif
                    </td>
                    <!-- 編集ボタン -->
                    @if(Auth::id() == $post->user_id)
                        <td class="table-text">
                          <form action="{{ url('postedit/'.$post->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">
                              編集
                            </button>
                          </form>
                        </td>
                      <!-- 削除ボタン -->
                        <td class="table-text">
                          <form action="{{ url('post/'.$post->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">
                              削除
                            </button>
                          </form>
                        </td>
                    @endif
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
@endsection