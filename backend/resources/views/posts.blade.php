<!-- resources/views/posts.blade.php -->
@extends('layouts.app')
@section('content')
  {{-- フォロー --}} {{-- フォロワー
  @php
    $user = App\User::find( $post->user_id );
  @endphp
  {{ $user->followUsers()->count() }}
  --}}
    <div class="wrapper">
    <div class="header"><h1>投稿ページ</h1></div>
    <div class="content_wrapper">
    <div class="content2">

        <form action="/newpostsend" method="post">
            @csrf
            <p>タイトル</p>
            <input type="text" name="title" class="formtitle">         
            <p>&nbsp;</p>
            <p>本文</p>
            <!-- <textarea name="main" cols="40" rows="10"></textarea> -->
            <div id="editor" style="height: 200px;"></div>
            <p>&nbsp;</p>
            <input type="submit" class="submitbtn">
        </form>

    </div>
    </div>
    </div>

    <script>
        var quill = new Quill('#editor', {
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline', 'strike'],
              [{'color': []}, {'background': []}],
              ['link', 'blockquote', 'image', 'video'],
              [{ list: 'ordered' }, { list: 'bullet' }]
            ]
          },
          placeholder: '',
          theme: 'snow'
        }); 
    </script>

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

   
@endsection
</main>
</div>
</body>
</html>