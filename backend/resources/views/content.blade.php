@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-lg-3">
  </div>
  <div class="col-lg-6">
    <img class="img_content float-center" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
    <h3 class="card-title">{{ $post->post_title }}</h3>
    <div class="row">
      <div class="col-sm-1">
        <img class="img_content_profile" src="{{ '/profile/'.($user->img_url) }}">
      </div>
      <div class="col-sm-4 pull-left">
        <p class="no-gutters">{{ $user->name }}</p>
        <p class="no-gutters">{{ $post->updated_at->format('Y/m/d') }}</p>
      </div>
    </div>
    <p class="card-text"><?= htmlspecialchars_decode($post->post_desc); ?></p>
    <a href="{{ url('/top') }}">トップに戻る</a><br>
    @if(Auth::check())
      <!-- フォロー処理//投稿者がログインユーザの場合 -->
      @if($user->id == Auth::id())
        <button type="submit" class="btn btn-primary">
            投稿者：{{ $user->name }}
        </button>
      <!-- フォロー処理 -->
      @elseif($user->followUsers()->where('following_user_id',Auth::id())->exists() !== true)
        <form action="{{ url('follow/'.$user->id) }}" method="POST">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-secondary">
            投稿者：{{ $user->name }}
          </button>
        </fome>
        {{ $user->followUsers()->count()}}
      @else<!-- フォロー削除 -->
        <form action="{{ url('follow_cancel', $user) }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger">
              投稿者：{{ $user->name }}フォロー中{{ $user->followUsers()->count() }}
            </button>
        </form>
      @endif

    <!-- お気に入り処理 -->
    @if($post->favo_user()->where('user_id',Auth::id())->exists() !== true)
      <form action="{{ url('post/'.$post->id) }}" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-secondary">
          お気に入り：{{ $post->favo_user()->count() }}
        </button>
      </form>
    @else
    <!-- お気に入り削除 -->
      <form action="{{ url('favo_cancel', $post) }}" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger">
          お気に入り：{{ $post->favo_user()->count() }}
        </button>
      </form>
    @endif

    <!-- いいね処理 -->
    @if($post->like_user()->where('user_id',Auth::id())->exists() !== true)
      <form action="{{ url('postlike/'.$post->id) }}" method="POST">
        {{  csrf_field()  }}
        <button type="submit" class="btn btn-secondary">
          いいね：{{ $post->like_user()->count() }}
        </button>
      </form>
    @else
    <!-- いいね削除 -->
      <form action="{{ url('like_cancel', $post) }}" method="POST">
        {{  csrf_field()  }}
        <button type="submit" class="btn btn-success">
          いいね：{{ $post->like_user()->count() }}
        </button>
      </form>
  </div>
  <div class="col-lg-3">
  </div>
</div>
    @endif
  @endif
@endsection