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
        <form action="{{ url('posts/update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- サムネイル画像 -->
            <div class="form-group">
              サムネイル画像
              <div class="col-sm-6">
                <input type="file" name="file_image" accept="image/png, image/jpeg" value="{{ Storage::url($post->file_path) }}">
              </div>
            </div>
            <!-- 投稿のタイトル -->
            <div class="form-group">
                投稿のタイトル
                <div class="col-sm-6">
                    <input type="text" name="post_title" class="form-control" value="{{ $post->post_title }}">
                </div>
            </div>
            <!-- 投稿の本文 -->
            <div class="form-group">
                投稿の本文
                <div class="col-sm-6">
                    <input type="text" name="post_desc" class="form-control" value="{{ $post->post_desc }}">
                </div>
            </div>
            <!--　登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <a class="btn btn-link pull-right" href="{{ url('/') }}">
                        back
                    </a>
                </div>
            </div>
            <input type="hidden" name="id" value="{{ $post->id }}" />
            {{ csrf_field() }}
        </form>
        <!-- /投稿フォーム -->
        @endif
    </div>
@endsection