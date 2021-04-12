<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Share Process') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
</head>
<body>
  <div id="app" class="footerFixed">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('top') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
          </ul>
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login.guest') }}">{{ __('ゲストログイン') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
            </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('会員登録') }}</a>
            </li>
          @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url('/mypage/post/'.Auth::user()->id) }}">マイページ</a>
                <a class="dropdown-item" href="{{ url('/posts/write') }}">記事を書く</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
          </ul>
        </div>
      </div>
  </nav>

<main class="py-4">
    <!--  エディタ表示部分  -->
    @include('common.errors')
  <form action="{{ url('/posts/save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
      投稿のタイトル
      <div class="col-sm-6">
        <input type="text" name="post_title" class="form-control">
      </div>
    </div>

    <div class="form-group">
      サムネイル画像
      <input type="file" name="file_image" accept="image/png, image/jpeg" onchange="previewImage(this);">
    </div>
    <script>
      function previewImage(obj) {
        var fr = new FileReader();
        fr.onload = (function() {
          document.getElementById('preview').src = fr.result;
        });
        fr.readAsDataURL(obj.files[0]);
        //画像表示
        var img_profile = document.getElementById('preview');
        img_profile.classList.add("img_profile_edit");
      }
    </script>
    <!-- サムネイル表示 -->
    <img id="preview" class="">

    <div class="form-groutp col-sm-6">
      <textarea id="editor" name="post_desc" placeholder="ここにテキストを書いてください"></textarea>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">
        保存する
      </button>
    </div>
  </fome>
  
  <script src="https://unpkg.com/vue@3.0.2/dist/vue.global.prod.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>

  <script>
    class UploadAdapter {
      constructor(loader) {
          this.loader = loader;
      }
      upload() {
          return this.loader.file
              .then(file => {
                  return new Promise((resolve, reject) => {
                      const url = '/posts/upload_image';
                      let formData = new FormData();
                      formData.append('image', file);

                      axios.post(url, formData)
                          .then(response => {
                              if(response.data.result === true) {
                                  const imageUrl = response.data.image_url;
                                  resolve({ default: imageUrl });
                              } else {
                                  reject();
                              }
                          })
                          .catch(error => {
                              reject();
                          });
                  });
              });
      }
    }
    function MyCustomUploadAdapterPlugin(editor){
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new UploadAdapter( loader );
      };
    }

    ClassicEditor
      .create(document.querySelector( '#editor' ), {
        extraPlugins:[MyCustomUploadAdapterPlugin],
      })
      .catch( error => {
        console.log(error);
      });
  </script>

  </main>
  </div>
  <footer class="footer border-top text-center">Share Process</footer>
</body>
</html>