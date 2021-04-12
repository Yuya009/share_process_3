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
        @if(Auth::check())
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
            <button type="submit" class="btn btn-primary">
              フォロー中
            </button>
          </form>
          @endif
        @endif
      </div>
    </div>
  </div>

  <!-- タブ -->
  <nav class="nav justify-content-center border-bottom">
    <a class="nav-link active" href="{{ url('/mypage/post/'.$user->id) }}">投稿記事</a>
    <a class="nav-link" href="{{ url('/mypage/favorite/'.$user->id) }}">お気に入り</a>
    <a class="nav-link disable" href="{{ url('/mypage/like/'.$user->id) }}">いいね</a>
  </nav>
  <!-- 記事の投稿 -->




  <!-- 全ての投稿リスト -->
      <div class="row posts_p">
        <div class="col-3">
        </div>
        <div class="col-6">
          @foreach ($posts as $post)
            <div class="row border-bottom">
              <div class="col-3 all_link">
                <img class="img_content" src="{{ Storage::url($post->file_path) }}">
                <a class="link_hidden" href="{{ url('/posts/content/'.$post->id) }}"></a>
              </div>

              <div class="col-6 pull-left all_link">
                <p class="no-gutters">{{ $post->post_title }}</p>
                <p class="no-gutters">{{ $post->updated_at->format('Y/m/d') }}</p>
                <a class="link_hidden" href="{{ url('/posts/content/'.$post->id) }}"></a>
              </div>

              <div class="col-3">
                @if(Auth::check())
                  @if(Auth::id() == $post->user_id)
                  @elseif(Auth::id() != $post->user_id && $post->favo_user()->where('user_id',Auth::id())->exists() !== true)
                    <form action="{{ url('post/'.$post->id) }}" method="POST">
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-secondary">
                        お気に入り
                      </button>
                    </form>
                  @else
                  <!-- お気に入り削除 -->
                  <form action="{{ url('favo_cancel/'.$post->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">
                      お気に入り
                    </button>
                  </form>
                  @endif

                  <!-- いいね処理 -->
                      @if(Auth::id() == $post->user_id)
                      @elseif($post->like_user()->where('user_id',Auth::id())->exists() !== true)
                        <form action="{{ url('postlike/'.$post->id) }}" method="POST">
                          {{  csrf_field()  }}
                          <button type="submit" class="btn btn-secondary">
                            いいね
                          </button>
                        </form>
                      @else
                        <!-- いいね削除 -->
                        <form action="{{ url('like_cancel', $post) }}" method="POST">
                          {{  csrf_field()  }}
                          <button type="submit" class="btn btn-success">
                            いいね
                          </button>
                        </form>
                      @endif

                  <!-- 編集ボタン -->
                  @if(Auth::id() == $post->user_id)
                    <form action="{{ url('/posts/edit/'.$post->id) }}" method="GET">
                      <button type="submit" class="btn btn-primary">
                        編集
                      </button>
                    </form>
                  <!-- 削除ボタン -->
                  <form action="{{ url('/posts/delete/'.$post->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger">
                        削除
                      </button>
                  </form>
                  @endif
                @endif
              </div>
            </div>
          @endforeach
        </div>
        <div class="col-3">
        </div>
      </div>
@endsection