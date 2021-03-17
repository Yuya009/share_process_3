@extends('layouts.app')
@section('content')
  <img class="img_size" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
  <h3 class="card-title">{{ $post->post_title }}</h3>
  <p class="card-text">{{ $post->post_desc }}</p>

  <a href="{{ url('/top') }}">トップに戻る</a>
  @if(Auth::check())
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