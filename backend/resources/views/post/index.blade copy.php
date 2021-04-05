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

</head>
<body>
    <div id="app">
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
                                    <a class="dropdown-item" href="{{ url(Auth::user()->id.'/post') }}">マイページ</a>
                                    <a class="dropdown-item" href="{{ url('/write') }}">記事を書く</a>
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

    <div id="app_edita" class="container p-3">
    <h1 class="mb-4">シンプルなCMSのサンプル</h1>

    <!-- 一覧表示部分 -->
    <div v-if="isStatusIndex">
        <div class="text-right pb-4">
            <button type="button" class="btn btn-success" @click="changeStatus('create')">追加</button>
        </div>
        <table class="table">
            <tr v-for="post in posts">
                <td v-text="post.post_title"></td>
                <td v-text="post.post_desc"></td>
                <td class="text-right">
                    <a :href="'/post/'+ post.id" class="btn btn-light mr-2" target="_blank">確認</a>
                    <button type="button" class="btn btn-warning mr-2" @click="setCurrentPost(post)">変更</button>
                    <button type="button" class="btn btn-danger" @click="onDelete(post)">削除</button>
                </td>
            </tr>
        </table>
    </div>

    <!--  エディタ表示部分  -->
    <div v-if="isStatusCreate || isStatusEdit">
        <input class="form-control mb-3" type="text" placeholder="タイトル" v-model="postTitle">
        <!-- <input type="file" name="file_image" accept="image/png, image/jpeg" v-model="postImage"> -->
        <!-- ここにリッチテキスト・エディタが表示されます -->
        <div id="editor"></div>
        <div class="text-right pt-4">
            <button type="button" class="btn btn-secondary mr-2" @click="changeStatus('index')">キャンセル</button>
            <button type="button" class="btn btn-primary" @click="onSave">保存する</button>
        </div>
    </div>

</div>
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
                      const url = '/editor_post/upload_image';
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

    Vue.createApp({
        data() {
            return {
                status: 'index', // ここの内容で表示切り替え
                posts: [],
                currentPost: {},
                postTitle: '',  // タイトル
                richEditor: null    // CKEditorのインスタンス
            }
        },
        methods: {
            initRichEditor(defaultDescription) {
                const target = document.querySelector('#editor');
                ClassicEditor.create(target)
                    .then(editor => {
                        this.postTitle = this.currentPost.title || '';
                        this.richEditor = editor; //editor
                        //ここでアダプターをセット
                        this.richEditor.plugins
                            .get('FileRepository')
                            .createUploadAdapter = loader => {
                              return new UploadAdapter(loader);
                            };
                        this.richEditor.setData(defaultDescription);
                    });
            },
            getPosts() {
                const url = '/editor_post/list';
                axios.get(url)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            setCurrentPost(post) {
                this.currentPost = post;
                this.status = 'edit';
            },
            changeStatus(status) {
                this.status = status;
            },
            onSave() {
                if(confirm('保存します。よろしいですか？')) {
                    let url = '';
                    let method = '';
                    if(this.isStatusCreate) {
                        url = '/editor_post';
                        method = 'POST';
                    } else if(this.isStatusEdit) {
                        url = `/post/${this.currentPost.id}`;
                        method = 'PUT';
                    }
                    const params = {
                        _method: method,
                        title: this.postTitle,
                        description: this.richEditor.getData()
                    };
                    axios.post(url, params)
                        .then(response => {
                            if(response.data.result === true) {
                                this.getPosts();
                                this.changeStatus('index');  //index
                            }
                        })
                        .catch(error => {
                            console.log(error); // エラーの場合
                        });
                }
            },
            onDelete(post) {
                if(confirm('削除します。よろしいですか？')) {
                    const url = `/post/${post.id}`;
                    axios.delete(url)
                        .then(response => {
                            if(response.data.result === true) {
                                this.getPosts();
                            }
                        });
                }
            }
        },
        computed: {
            isStatusIndex() {
                return (this.status === 'index');
            },
            isStatusCreate() {
                return (this.status === 'create');
            },
            isStatusEdit() {
                return (this.status === 'edit');
            }
        },
        watch: {
            status(value) {
                if(value === 'create') {
                    this.currentPost = {};
                }
                const editorKeys = ['create', 'edit'];
                const defaultDescription = (value === 'edit') ? this.currentPost.description : '';
                if(editorKeys.includes(value)) { // `create` か `edit` の場合だけ CKEditor を起動
                    Vue.nextTick(() => {
                        this.initRichEditor(defaultDescription);
                    });
                }
            }
        },
        setup() {
            return {
                richEditor: Vue.reactive({}) // reactive変数をつくる
            }
        },
        mounted() {
            this.getPosts();
        }
    }).mount('#app');
</script>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="footer border-top text-center">Share Process</footer>
</body>
</html>