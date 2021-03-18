@extends('layouts.app')
@section('content')
  <img class="img_size" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
  <h3 class="card-title">{{ $post->post_title }}</h3>
  <p class="card-text">{{ $post->post_desc }}</p>
  <a href="{{ url('/top') }}">トップに戻る</a><br>
  @if(Auth::check())
    @php
      $user = App\User::find( $post->user_id );
    @endphp
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
    @else<!-- フォロー削除 -->
      <form action="{{ url('follow_cancel', $user) }}" method="POST">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-danger">
            投稿者：{{ $user->name }}フォロー中{{-- $user->followUsers()->count() --}}
          </button>
      </form>
    @endif
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
    @endif
  @endif
@endsection