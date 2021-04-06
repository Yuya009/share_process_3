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
      <div class="col-7">{{-- 名前など --}}
        <div class="col-12 text-left">
          {{ $user->name }}<br>
          {{ $user->introduction }}
        </div>
        <div class="col-5 text-left">
          <a href="{{ url('/mypage/followings/'.$user->id) }}">{{ $user->follows()->count() }}フォロー</a>
          <a href="{{ url('/mypage/followers/'.$user->id) }}">{{ $user->followUsers()->count() }}フォロワー</a><br>
        </div>
        <div class="col-5">
          @if(Auth::id() == $user->id)
            <form action="{{ url('/mypage/edit/'.$user->id) }}" method="GET">
              <button type="submit" class="">
                プロフィール編集
              </button>
            </form>
          @endif
        </div>
      </div>
      <div class="col-2">
        @if($user->id == Auth::id())

        @elseif($user->followUsers()->where('following_user_id',Auth::id())->exists() !== true)
        <form action="{{ url('follow/'.$user->id) }}" method="POST">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-secondary">
            フォローする
          </button>
        </fome>
        @else
        <form action="{{ url('follow_cancel', $user) }}" method="POST">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-danger">
            フォロー中
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>

  <!-- タブ -->
  <nav class="nav justify-content-center">
    <a class="nav-link active" href="{{ url('/mypage/post/'.$user->id) }}">投稿記事</a>
    <a class="nav-link" href="{{ url('/mypage/favorite/'.$user->id) }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url('/mypage/like/'.$user->id) }}">いいね</a>
  </nav>
  <!-- 記事の投稿 -->




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
                          <form action="{{ url('/posts/edit/'.$post->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">
                              編集
                            </button>
                          </form>
                        </td>
                      <!-- 削除ボタン -->
                        <td class="table-text">
                          <form action="{{ url('/posts/delete/'.$post->id) }}" method="POST">
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