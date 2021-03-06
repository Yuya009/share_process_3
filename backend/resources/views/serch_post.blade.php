<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <!-- 検索 -->
    <div class="row border-bottom">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <p class="h3">検索結果："{{$keyword}}"</p>
      </div>
      <div class="col-md-3"></div>
    </div>
    <!-- 全ての投稿リスト -->
      
        <!-- 3列表示 -->
        <div class="container">
            <div class="row justify-content-center">
            @foreach ($posts as $post)
              <div class="card card-contents" style="width: 20rem;">
                <a class="link_hidden" href="{{ url('/posts/content/'.$post->id) }}">
                  <img class="img_size rounded" src="{{ Storage::url($post->file_path) }}" alt="カード画像">
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
        {{ $posts->appends(['keyword'=>$keyword])->links() }}
      </div>
    </div>
@endsection