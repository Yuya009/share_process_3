<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->

    <!-- 全ての投稿リスト -->
     <?php $count = 0; ?>
      <p class="border-bottom h3">　　　　　　　記事一覧</p>
      @foreach ($posts as $post)
        <!-- 3列表示 -->
        @if ($loop->index % 3 == 0)
          <div class="container">
            <div class="row">
        @endif
              <div class="card">
                <a class="link_hidden" href="{{ url('post/'.$post->id) }}">
                  <img class="img_size" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
                  <div class="card-body">
                    <h3 class="card-title">{{ $post->post_title }}</h3>
                    <p class="card-text">{{ $post->post_desc }}</p>
                  </div>
                </a>
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
                  
              </div>
              <?php $count++; ?>
        @if ($loop->iteration % 3 == 0 || count($posts) == $count )
            </div>
          </div>
        @endif
      @endforeach
    <div class="row">
      <div class="col-md-4 offset-md-4">
        {{ $posts->links() }}
      </div>
    </div>
@endsection