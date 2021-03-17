<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            投稿フォーム
        </div>
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <!-- 投稿フォーム -->
        @if( Auth::check() )
        <form action="{{ url('posts') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- サムネイル画像 -->
            <div class="form-group">
              サムネイル画像
              <div class="col-sm-6">
                <input type="file" name="file_image" accept="image/png, image/jpeg">
              </div>
            </div>
            <!-- 投稿のタイトル -->
            <div class="form-group">
                投稿のタイトル
                <div class="col-sm-6">
                    <input type="text" name="post_title" class="form-control">
                </div>
            </div>
            <!-- 投稿の本文 -->
            <div class="form-group">
                投稿の本文
                <div class="col-sm-6">
                    <input type="text" name="post_desc" class="form-control">
                </div>
            </div>
            <!--　登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
        <!-- /投稿フォーム -->

        @endif
    </div>
    <!-- 全ての投稿リスト -->
    @if (count($posts) > 0)
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
                          @if(Auth::id() == $post->user_id)
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
                            </tr>
                          @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>		
    @endif
    <!-- ログインユーザーのみ表示 -->
    @if( Auth::check() )
          <div class="card-body">
              <div class="card-body">
                  <table class="table table-striped task-table">
                      <!-- テーブルヘッダ -->
                      <thead>
                          <th>お気に入り一覧</th>
                          <th>&nbsp;</th>
                      </thead>
                      <!-- テーブル本体 -->
                      <tbody>
                          @foreach ($favo_posts as $favo_post)
                              <tr>
                                  <!-- 投稿タイトル -->
                                  <td class="table-text">
                                      <div>{{ $favo_post->post_title }}</div>
                                  </td>
                                  <!-- 投稿詳細 -->
                                  <td class="table-text">
                                      <div>{{ $favo_post->post_desc }}</div>
                                  </td>
                                  <!-- 投稿者名の表示 -->
                                  <td class="table-text">
                                      <div>{{ $favo_post->user->name }}</div>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  
                  <table class="table table-striped task-table">
                      <!-- テーブルヘッダ -->
                      <thead>
                          <th>いいね一覧</th>
                          <th>&nbsp;</th>
                      </thead>
                      <!-- テーブル本体 -->
                      <tbody>
                          @foreach ($like_posts as $like_post)
                              <tr>
                                  <!-- 投稿タイトル -->
                                  <td class="table-text">
                                      <div>{{ $like_post->post_title }}</div>
                                  </td>
                                  <!-- 投稿詳細 -->
                                  <td class="table-text">
                                      <div>{{ $like_post->post_desc }}</div>
                                  </td>
                                  <!-- 投稿者名の表示 -->
                                  <td class="table-text">
                                      <div>{{ $like_post->user->name }}</div>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
    @endif
@endsection