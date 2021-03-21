<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  <!-- バリデーションエラーの表示に使用-->
  @include('common.errors')
  <!-- バリデーションエラーの表示に使用-->
  <?php $count = 0; ?>
    @foreach ($followers as $follow)
      @if ($loop->index % 3 == 0)
        <div class="container">
          <div class="row">
      @endif
            <div class="card">
              <img src='' class='card-img-top'>
              <div class='card-body'>
                <h5 class='card-title'>{{ $follow->name }}</h5>
                <p class='card-text'>{{ $follow->id }}</p>
              </div>
                @if(Auth::check())
                  <!-- フォロー処理//投稿者がログインユーザの場合 -->
                  @if($user->id == Auth::id())
                    <button type="submit" class="btn btn-primary">
                      フォロー
                    </button>
                  <!-- フォロー処理 -->
                  @elseif($user->followUsers()->where('following_user_id',Auth::id())->exists() !== true)
                    <form action="{{ url('follow/'.$user->id) }}" method="POST">
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-secondary">
                        {{ $follow->name }}
                        {{ $follow->id }}
                      </button>
                    </fome>
                    {{ $user->followUsers()->count()}}
                  @else<!-- フォロー削除 -->
                    <form action="{{ url('follow_cancel', $user) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">
                          フォロー中
                        </button>
                    </form>
                  @endif
                @endif
              </div>
      <?php $count++; ?>
      @if($loop->iteration % 3 == 0 || count($followers) == $count )
            </div>
          </div>
      @endif
    @endforeach
@endsection