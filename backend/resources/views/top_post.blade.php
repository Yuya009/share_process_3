<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <!-- 全ての投稿リスト -->
      <p class="border-bottom h3">　記事一覧</p>
        <!-- 3列表示 -->
        <div class="container">
            <div class="row justify-content-center">
            @foreach ($posts as $post)
              <div class="card card-contents" style="width: 20rem;">
                <a class="link_hidden" href="{{ url('post/'.$post->id) }}">
                  <img class="img_size" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
                  <div class="card-body">
                    <h3 class="card-title card_abridgement_2">{{ $post->post_title }}</h3>
                    <!-- <p class="card-text card_abridgement_3"><?= htmlspecialchars_decode($post->post_desc); ?></p> -->
                  </div>
                </a>
                  @if(Auth::check())
                    <div class = "row">
                      <div class="col-lg-6 text-center">
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
                      </div>
                      <!-- いいね処理 -->
                      <div class="col-lg-6 text-center">
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
                      </div>
                    </div>
                  @endif
              </div>
            @endforeach
            </div>
          </div>
    <div class="row justify-content-center">
      <div class="">
        {{ $posts->links() }}
      </div>
    </div>
@endsection